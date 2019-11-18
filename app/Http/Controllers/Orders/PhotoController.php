<?php

namespace App\Http\Controllers\Orders;
use App\Models\Order;
use App\Services\YandexDiskTransferService;
use Illuminate\Support\Facades\Log;

use Yandex\Disk\DiskClient;


class PhotoController extends BaseController
{
    public function getPortraitsPhotos($orderTextLink, $count){
        $disk = new \Arhitector\Yandex\Disk( env('YANDEX_OAUTH') );

        $orderDirName = (string) $this->getOrderDirName($orderTextLink);
        $portraitPhotos = $disk->getResource($orderDirName.'/ПОРТРЕТЫ');
        $linksArray = $this->getFileLinks($portraitPhotos, $orderTextLink, $count);

        return  $this->sendResponse($linksArray);
    }

    public function getGroupsPhotos($orderTextLink, $count){

    }

    /**
     * @param $textLink
     * @return string
     */
    public function getOrderDirName ($textLink){
        return Order::where('link_secret', '=', $textLink)->first()->photos_dir_name;
    }

    /**
     * @param $photos
     * @param $orderTextLink
     * @param $count
     * @return array
     */
    public function getFileLinks($photos, $orderTextLink, $count){
        $dirName =  $this->getOrderDirName($orderTextLink);
        $portaitsLinks = array();

        if($this->isExists($photos, $orderTextLink)){
            foreach ($photos->items as $photo){
                if($photo->isFile() and $count>0){
                    $photo->setPublish(true);

                    $link = $photo->public_url;
                    $curl = curl_init($link); //расшаренная ссылка на картинку
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($curl);
                    preg_match('#<meta property="og:image" content="(.*?)">#si', $result, $matches);
                    $link = str_replace('amp;', '', $matches[1]);
                    $link = str_replace('&crop=1', '', $link);
                    $link = str_replace('&logo=1', '', $link);

                    array_push($portaitsLinks, $link);
                    $count--;
                }
                else{
                    Log::info('Обнаружена папка внутри '. $dirName.'/Портреты' .', заказ '.$orderTextLink);
                }
            }
        }
        else{
            Log::critical("Папка ". $dirName . " не обнаружена ".$orderTextLink);
        }

        return $portaitsLinks;
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
