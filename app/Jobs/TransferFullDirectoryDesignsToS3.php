<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class TransferFullDirectoryDesignsToS3 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $designPath;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($designPath)
    {
        $this->designPath = $designPath;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $diskClient= new \Arhitector\Yandex\Disk( env('YANDEX_OAUTH') );
        $portraitPhotosContent= $diskClient->getResource( $this->designPath, 5);
        $this->_addImagesToOptimizeJob($portraitPhotosContent);
    }

    /**
     * @param $dir object of YandexDisk client
     * @append string (the part of path to append)
     * @return void
     */
    protected function _addImagesToOptimizeJob ($dir) {
        foreach ($dir->toObject()->items as $photo){
            if($photo->isFile()){

                OptimizeThenTransferImage::dispatch($dir->path, $photo->name)->onQueue('transfer');
            }
            else {
                Log::info($photo->path.' не является фотографией');
            }
        }
    }
}
