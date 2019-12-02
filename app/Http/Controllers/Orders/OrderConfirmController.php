<?php

namespace App\Http\Controllers\Orders;

use App\Http\Requests\confirmOrderRequest;
use App\Models\Order;
use App\Models\OrderUser;
use App\Http\Controllers\Orders\BaseController;
use Illuminate\Support\Facades\DB;

class OrderConfirmController extends BaseController
{

    public function index($textLink){
        $orderId = $this->_getOrderId($textLink);
        $usersNames = OrderUser::where('id_order', '=', $orderId)->get();
        $usersDesigns = $this->_getUserDesignsChoice($usersNames);
        $totalDesignsCount = $this->_countUnicalDesignsChoices( $orderId);
        $mostPopularDesigns = $this->_getMostPopularDesignChoices( $orderId, 2 ); //2 - количество макс. дизайнов, указано заказчиком по условию ТЗ

        $groupsPhoto = $this->_getUsersGroupChoices( $orderId);
        $orderDirName = Order::find($orderId)->photos_dir_name;

        $groupsPhoto = $this->getFullImgUrlFromJson( $this->makeCustomJson($groupsPhoto), $orderDirName, 'ОБЩИЕ');

        return view('orders.client.confirm',
            compact('textLink', 'usersNames', 'usersDesigns',
                'totalDesignsCount', 'mostPopularDesigns', 'groupsPhoto'));
    }

    public function finalConfirm( confirmOrderRequest $request)
    {
        $orderId = $this->_getOrderId($request->textLink);
        $order = Order::find($orderId);

        $verifiedKey = $order->confirm_key;
        if ($request->confirm_key === $verifiedKey){
            $order->is_closed = true;
            $order->save();

            return response()->json(['status'=>true]);
        }
        else{
            return response('',400);
        }
    }

    /**
     * @param $textLink
     * @return integer
     */
    public function _getOrderId($textLink){
        $id =  Order::where('link_secret', '=', $textLink)->pluck('id');
        return $id[0];
    }

    public function _getUserDesignsChoice($usersNames){
        $usersDesigns = array(); // [ string => string ]
        foreach ($usersNames as $user){
            $usersDesigns[$user->name] = $user->design;
        }
        return $usersDesigns;
    }

    /**
     * @param int $orderId
     * @return int
     */
    public function _countUnicalDesignsChoices(int $orderId){
        $count = OrderUser::where('id_order', '=', $orderId)->distinct('design')->count();
        return (int) $count;
    }

    public function _getMostPopularDesignChoices(int $orderId, int $max){
        $designs =  DB::select(
            'SELECT design, count(*) c FROM order_users WHERE id_order=:id GROUP BY design ORDER BY c DESC LIMIT :max;',
            ['id' => $orderId, 'max' => $max]
        );

        $designs = $this->_getOnlyDesignsName($designs);

        return $designs;
    }

    /**
     * get: [ int=>[ stdClass {(string) designName, (int) c}  ], ...   ]
     * return: ['design', 'design']
     *
     * @param array &$designs
     * @return array
     */
    private function _getOnlyDesignsName(array $designs){
        foreach ($designs as $index=>$designArray){
            $designs[$index] = $designArray->design;
        }

        return $designs;
    }

    private function _getUsersGroupChoices(int $orderId){
        $groupPhotosFinalArray = array();

        $ordersChoicesArray = OrderUser::where('id_order', '=', $orderId)->pluck('common_photos');
        foreach ($ordersChoicesArray as $choiceArray){
            $choiceArray = json_decode($choiceArray, true)['nums'];
            foreach ($choiceArray as $photo){
                if( isset( $groupPhotosFinalArray[$photo] ) ){
                    $groupPhotosFinalArray[$photo]+=1;
                }
                else {
                    $groupPhotosFinalArray[$photo] = 1;
                }
            }
        }
        arsort($groupPhotosFinalArray);

        //Ограничим массив фотографий по условиям из заказа
        $count = Order::find($orderId)->photo_common;
        array_slice($groupPhotosFinalArray, $count);


        return $groupPhotosFinalArray;
    }

}
