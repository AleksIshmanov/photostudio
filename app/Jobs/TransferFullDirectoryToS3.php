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

        //Выполнится только если проверки все проверки корректны
        $this->photosDirectoryPath = $dirName;
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
                OptimizeThenTransferImage::dispatch($fullDirPath, $photo->name)->onQueue('transfer');
            }
            else {
                Log::info($photo->path.' не является фотографией');
            }
        }

        return $count;
    }
}
