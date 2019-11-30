<?php

namespace App\Http\Controllers\Orders;

use App\Models\Order;
use App\Models\OrderUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderConfirmController extends Controller
{

    public function index($textLink){
        $orderId = $this->_getOrderId($textLink);
        $usersNames = OrderUser::where('id_order', '=', $orderId)->get();
        $usersDesigns = $this->_getUserDesignsChoice($usersNames);
        $totalDesignsCount = $this->_countUnicalDesignsChoices( $orderId);
        $mostPopularDesigns = $this->_getMostPopularDesignChoices( $orderId, 2 ); //2 - количество макс. дизайнов, указано заказчиком по условию ТЗ


        return view('orders.client.confirm', compact('textLink', 'usersNames', 'usersDesigns', 'totalDesignsCount', 'mostPopularDesigns'));
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


}
