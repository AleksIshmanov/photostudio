<?php

namespace App\Http\Controllers\Orders;
use App\Models\Order;
use App\Services\YandexDiskTransferService;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;
use Yandex\Disk\DiskClient;


class PhotoController extends BaseController
{
    public function getPortraitsPhotos($orderTextLink, $start, $count=50){
        $storageClient = Storage::disk('yadisk');
        $orderDirName = (string) $this->getOrderDirName($orderTextLink).'/ПОРТРЕТЫ';

        $linksArray = $this->getFileLinks($storageClient, $orderDirName, $start, $count);


        return  json_encode( $linksArray, true );
    }

    public function getGroupsPhotos($orderTextLink, $start, $count){
        $storageClient = Storage::disk('yadisk');
        $orderDirName = (string) $this->getOrderDirName($orderTextLink).'/ОБЩИЕ';

        $linksArray = $this->getFileLinks($storageClient, $orderDirName, $start, $count);

        return  json_encode( $linksArray, true );
    }

    /**
     * @param $textLink
     * @return string
     */
    public function getOrderDirName ($textLink){
        return Order::where('link_secret', '=', $textLink)->first()->photos_dir_name;
    }


    public function getFileLinks($storageClient, $orderDirName, $start, $count){
        $links = array();
        $files = $storageClient->allFiles($orderDirName);

        $files = array_slice($files, $start, $count);

        foreach ($files as $photo){
            array_push($links, $storageClient->url($photo));
        }

        return $links;
    }

    /**
     * @param $resource
     * @param $linkId
     * @return bool
     */
    public function isExists($resource, $linkId){
        if( $resource->has() )
            return true;
        else {
            Log::warning("Невозможно найти папку {" . "} для заказа" . $linkId);
            return false;
        }
    }

}
