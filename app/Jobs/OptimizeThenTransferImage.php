<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

ini_set('memory_limit', '500M');
class OptimizeThenTransferImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $basicPath = 'public/transfer/'; //storage basic for Storage::disk('local');
    protected $relativePathBeforeOptimization = 'public/transfer/before/';  //before optimize
    protected $relativePathAfterOptimization = 'public/transfer/after/'; //after optimezation
    protected $imgDirPath;
    protected $imgName;

    /**
     * Create a new job instance.
     * @param  string $imgPath
     * @return void
     */
    public function __construct($orderDirPath, $imgName )
    {
        //Очищаем путь от лишних деталей
        $orderDirPath = str_replace('disk:/', '', $orderDirPath);

        $this->imgDirPath = $orderDirPath;
        $this->imgName = $imgName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $diskClient= new \Arhitector\Yandex\Disk( env('YANDEX_OAUTH') );

        $absImgPathBeforeOptimization = $this->downloadImg($diskClient, $this->imgName, $this->imgDirPath);

        $relAfter = $this->relativePathAfterOptimization.$this->imgDirPath;
        $absolutePathToSave = $this->getAbsolutePath($relAfter).$this->imgName;

        $absImgPathAfterOptimization = $this->resizeImg($absImgPathBeforeOptimization, $absolutePathToSave);
        $this->compressImg($absImgPathAfterOptimization);

        //указываем локальный путь, так как Storage работает на относительных путях

        Storage::disk('yadisk')->put($this->imgDirPath.'/'.$this->imgName, file_get_contents($absImgPathAfterOptimization));

        $this->deleteTempFiles($absImgPathBeforeOptimization,  $absImgPathAfterOptimization);
    }

    /**
     * @param \Arhitector\Yandex\Disk $diskClient
     * @param $imgName
     * @param $cloudStorageDir
     * @return string (absolute path to downloaded image)
     */
    function downloadImg($diskClient, $imgName, $cloudStorageDir){

        if(!Storage::exists($this->basicPath)
            || !Storage::exists($this->relativePathBeforeOptimization.$cloudStorageDir)
            || !Storage::exists($this->relativePathAfterOptimization.$cloudStorageDir)
        ){

            Storage::makeDirectory($this->basicPath);
            Storage::makeDirectory($this->relativePathBeforeOptimization.$cloudStorageDir);
            Storage::makeDirectory($this->relativePathAfterOptimization.$cloudStorageDir);
        }

        $absImgPath = $this->getAbsolutePath($this->relativePathBeforeOptimization.$cloudStorageDir).$imgName;
        $diskClient->getResource($cloudStorageDir.'/'.$imgName)->download($absImgPath, true);

        return $absImgPath;
    }

//    function createDirectoryTree($path){
//        $path = str_replace("\\", '/', $path);
//        foreach ( explode('/', $path) as $part){
//            $absPath = $this->getAbsolutePath($part);
//            dd($absPath);
//            Storage::disk('local')->makeDirectory($absPath);
//        }
//    }

    /**
     * Make absolute path from relative
     *
     * @param $relativePath
     * @return string
     */
    function getAbsolutePath($relativePath){
        return (string) storage_path().'/app/'. $relativePath.'/';
    }


    /**
     * @param $imgName
     * @return string (resized img absolutePath)
     */
    function resizeImg($absoluteImgPath, $absolutePathToSave){

        $width = 600; // max width
        $height = 600; // max height
        $img = Image::make($absoluteImgPath)->orientate();

        ($img->height() > $img->width()) ? $width=null : $height=null;
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img->save($absolutePathToSave);
        $img->destroy(); //удаляем изображение из оперативной памяти
        return $absolutePathToSave;
    }

    /**
     * @param $absoluteImgPath
     * @return bool
     */
    function compressImg ($absoluteImgPath){
        $filesize= getimagesize($absoluteImgPath);
        $type = exif_imagetype($absoluteImgPath); //возвращает число соотв. типа (см. описание функции)
        $quality = 60; //Качество в процентах. В данном случае будет сохранено 60% от начального качества.
        $size = 10485760; //Максимальный размер файла в байтах. В данном случае приблизительно 10 МБ.

        if($filesize>$size){
            switch($type){
                case 2: $source = imagecreatefromjpeg($absoluteImgPath); break; //Создаём изображения по
                case 3: $source = imagecreatefrompng($absoluteImgPath); break;  //образцу загруженного
                case 1: $source = imagecreatefromgif($absoluteImgPath); break; //исходя из его формата
                default: return false;
            }
            imagejpeg($source, $absoluteImgPath, $quality); //Сохраняем созданное изображение по указанному пути в формате jpg
            imagedestroy($source);//Чистим память
            return true;
        }
        else return false;
    }

    /**
     * @return void
     */
    function deleteTempFiles($absPathBefore, $absPathAfter){
        File::delete($absPathBefore);
        File::delete( $absPathAfter);
    }
}
