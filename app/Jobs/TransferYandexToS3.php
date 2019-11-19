<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

ini_set('memory_limit', '500M');
class TransferYandexToS3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $photosDirectoryPath; //название директории с фотографиями

    /**
     * TransferYandexToS3 constructor.
     *
     * @param $dirName
     * @throws \Exception
     * @throws \Arhitector\Yandex\Client\Exception\UnauthorizedException
     * @throws \Arhitector\Yandex\Client\Exception\NotFoundException
     * @return void
     */
    public function __construct($dirName)
    {

        $test = $this->_validate($dirName);
        switch ($test){
            case 0:
                throw new \Arhitector\Yandex\Client\Exception\NotFoundException('Папка не найдена. Помните: пробелы, заглавные буквы и другие знаки влияют на название.');
                break;
            case 1:
                throw new \Arhitector\Yandex\Client\Exception\UnauthorizedException('Яндекс диск не доступен. Проверьте параметры токенов приложения.');
                break;
            case 2:
                throw new \Exception('Ошибка при иницициализации диска. Проверьте корректность токенов приложения.');
                break;
        }

        //dd($test);
        //Выполнится только если проверки все проверки корректны
        $this->photosDirectoryPath = $dirName;
    }

    /**
     * В случае системных ошибок, задание не будет добавлено в очередь.
     * Ошибки обрабатываются на месет вызова (OrderController.php )
     *
     * @param $dirName
     * @return int
     */
    private function _validate($dirName){
        try {
            $diskClient= new \Arhitector\Yandex\Disk( env('YANDEX_OAUTH') );
            $test = $diskClient->getResource($dirName);


            Storage::disk('yadisk')->put('testConnection.txt', '0');

//            dd($test->has(), $dirName,  $diskClient->getResource($dirName) );
        }
        catch (\Arhitector\Yandex\Client\Exception\NotFoundException $e) {
            return 0;
        }
        catch (\Arhitector\Yandex\Client\Exception\UnauthorizedException $e){
            Log::error('Yandex Disk REST initialization error. at'. __METHOD__. ' '. $e->getMessage());
            return 1;
        }
        catch (\Exception $e) {
            Log::error('S3 disk initialization error. at'. __METHOD__. ' '. $e->getMessage());
            return 2;
        }
        //TODO Проверить корректность форматирования папки (наличие "ПОРТРЕТЫ" и "ОБЩИЕ")

        return -1;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // initialize cloud connection Drivers
        $cloudS3Client = Storage::disk('yadisk');
        $diskClient= new \Arhitector\Yandex\Disk( env('YANDEX_OAUTH') );

        $portraitPhotosContent= $diskClient->getResource( $this->photosDirectoryPath.'/ПОРТРЕТЫ' );
        $groupPhotosContent = $diskClient->getResource( $this->photosDirectoryPath.'/ОБЩИЕ' );

        $countPhoto = $this->transferProcess($cloudS3Client, $portraitPhotosContent);
        $countGroup = $this->transferProcess($cloudS3Client, $groupPhotosContent);
    }


    public function transferProcess ($storageS3Client, $dir) {
        $count = 0;

        foreach ($dir->items as $photo){

            if($photo->isFile()){
                $optimizedPhotoPath = $this->optimizeImage($photo->name, $photo);
                $path = str_replace('disk:/', '', $photo->path);

                if($storageS3Client->put($path, file_get_contents($optimizedPhotoPath))){
                    Log::info('Загрузка из Yandex в S3 хранилище выполнена, файл: '. $path);
                    $count+=1;

                    //удаляем обработанное фото
                    Storage::disk('local')->delete($optimizedPhotoPath);
                }
                else {
                    Log::warning('Ошибки при загрузке файлов в хранилище, файл:'. $path);
                }
            }
            else {
                Log::info($photo->path.' не является фотографией');
            }
        }

        return $count;
    }

    public function optimizeImage($imgName, $photo){
        $basic = (string) 'public/transfer/';
        $pathBefore = $basic.'before/';
        $pathAfter = $basic.'after/';

        if(!Storage::exists($basic) || !Storage::exists($pathBefore) || !Storage::exists($pathAfter) ){
            Storage::makeDirectory($basic);
            Storage::makeDirectory($pathBefore);
            Storage::makeDirectory($pathAfter);
        }

        // при загрузке через ЯНдекс Диск нужен абсолютный путь
        $absPathBefore = storage_path().'/app/'. $pathBefore;
        $absPathAfter = storage_path().'/app/'. $pathAfter;

        $photo->download($absPathBefore.$imgName, true);
        $img = Image::make($absPathBefore.$imgName);

        //обрезаем
        if($img->height()>$img->width()){
            $img->resize(200, 300);
        }
        else {
            $img->resize(300,200);
        }

        //сжимаем
        $this->compress_image($absPathBefore, $imgName);
        $img->save($absPathAfter.$imgName);

        //удаляем старое фото (новое удалим после отправки на S3 серве)
        Storage::disk('local')->delete($pathBefore.$imgName);

        return (string) $absPathAfter.$imgName;
    }

    function compress_image($path, $imgName, $tmp_name='compress'){
        $fullName = $path.$imgName;

        $filesize= getimagesize($fullName);
        $type = exif_imagetype($fullName); //возвращает число соотв. типа
        $quality = 60; //Качество в процентах. В данном случае будет сохранено 60% от начального качества.
        $size = 10485760; //Максимальный размер файла в байтах. В данном случае приблизительно 10 МБ.

        if($filesize>$size){
            switch($type){
                case 2: $source = imagecreatefromjpeg($fullName); break; //Создаём изображения по
                case 3: $source = imagecreatefrompng($fullName); break;  //образцу загруженного
                case 1: $source = imagecreatefromgif($fullName); break; //исходя из его формата
                default: return false;
            }
            imagejpeg($source, $fullName, $quality); //Сохраняем созданное изображение по указанному пути в формате jpg
            imagedestroy($source);//Чистим память
            return true;
        }
        else return false;
    }


}
