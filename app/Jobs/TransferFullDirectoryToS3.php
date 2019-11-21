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
use Yandex\DataSync\Responses\DatabaseDeltasResponse;

class TransferFullDirectoryToS3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $photosDirectoryPath; //название директории с фотографиями

    /**
     * TransferFullDirectoryToS3 constructor.
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
            case 10:
                throw new \Arhitector\Yandex\Client\Exception\NotFoundException("Папка '$dirName' найдена, но все фотографии должны быть распределены по двум подпапкам 'ОБЩИЕ' и 'ПОРТРЕТЫ'. Исправьте и повторите попытку.");
                break;
        }

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
            $diskClient->getResource($dirName)->toObject(); //ошибки выпадают только при физическом преобразовании объекта (метод ->toArray())

            Storage::disk('yadisk')->put('testConnection.txt', '0');

            //проверка на корректность форматирования папки
            try {
                $diskClient->getResource($dirName.'/ПОРТРЕТЫ')->toObject();
                $diskClient->getResource($dirName.'/ОБЩИЕ')->toObject();
            }
            catch (\Arhitector\Yandex\Client\Exception\NotFoundException $e) {
                return 10;
            }

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
        return -1;
    }

    /**
     * ВНИМАНИЕ!
     * Данный класс разбивает задачу обработки на множество одиночных процессов. Алгоритм
     * 1. Валидация данных
     * 2. Сканирует все файлы папки из disk.yandex.ru
     * 3. Разбивает всю обработку на множество отдельных процессов OptimizeThenTransferImage.phpferImage.php
     * 4. Добавляет задание TransferOptimizedImages, которое выполнится после завершения всех процессов из очереди OptimizeThenTransferImage
     *
     * @return void
     */
    public function handle()
    {
        $diskClient= new \Arhitector\Yandex\Disk( env('YANDEX_OAUTH') );

        $portraitPhotosContent= $diskClient->getResource( $this->photosDirectoryPath.'/ПОРТРЕТЫ', 10000 );
        $groupPhotosContent = $diskClient->getResource( $this->photosDirectoryPath.'/ОБЩИЕ', 10000 );

        $countPortrait = $this->_addImagesToOptimizeJob($portraitPhotosContent, '/ПОРТРЕТЫ');
        $countGroup = $this->_addImagesToOptimizeJob($groupPhotosContent, '/ОБЩИЕ');

        Log::info("Для папки $this->photosDirectoryPath было добавлено: портретов->$countPortrait, общих->$countGroup.");

    }

    /**
     * @param $dir object of YandexDisk client
     * @append string (the part of path to append)
     * @return int count of added files
     */
    protected function _addImagesToOptimizeJob ($dir, $append) {
        $count = 0;

        foreach ($dir->toObject()->items as $photo){
            $count++;

            if($photo->isFile()){
                $fullDirPath = $this->photosDirectoryPath.$append;
                OptimizeThenTransferImage::dispatch($fullDirPath, $photo->name)->onQueue('9_priority');
            }
            else {
                Log::info($photo->path.' не является фотографией');
            }
        }

        return $count;
    }
}
