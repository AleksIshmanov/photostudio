<?php

namespace App\Http\Controllers\Orders\Admin;

use App\Http\Controllers\Orders\BaseController;
use App\Http\Requests\storeNewOrderUserRequest;
use App\Models\Order;
use App\Models\OrderUser;
use Illuminate\Http\Request;

class OrderUserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $link_text, int $user_id)
    {
        $order = Order::where('link_secret', '=', $link_text)->first();

        $orderDirName = $order->photos_dir_name;
        $user = OrderUser::where('id_order', '=', $order->id)
            ->where('id', '=', $user_id)
            ->first();

        $portraitsPhoto = $this->getFullImgUrlFromJson($user->portraits, $orderDirName,'ПОРТРЕТЫ');
        $groupsPhoto = $this->getFullImgUrlFromJson($user->common_photos, $orderDirName,'ОБЩИЕ');
        $designs = $this->getUserDesign( $user->design, DesignsController::getDesignsFromS3() );

        return view('orders.client.demo', compact('user', 'groupsPhoto', 'portraitsPhoto', 'designs'));
    }

    /**Make userChoices to full array with design images for view
     *
     * was: ['07', 5]
     * return: ['07'=>[url1, url2, url3, ...]
     *
     * @param int|string &$userChoice
     * @param array $allDesigns
     * @return array
     */
    private function getUserDesign($userChoice, array $allDesigns){
        return isset($allDesigns[$userChoice]) ? [$userChoice => $allDesigns[$userChoice]] : [];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeNewOrderUserRequest $request)
    {
        $orderUser = new OrderUser();
        $orderTextLink = $request->input('textLink');

        $orderUser->name = $request->input('userName') .' '. $request->input('userSurname');
        $orderUser->id_order = $this->getOrderId($orderTextLink);
        $orderUser->portrait_main = $request->input('theBigPortraitPhoto');
        $orderUser->portraits = $this->makeCustomJson($request->input('mainPhotos'));
        $orderUser->common_photos = $this->makeCustomJson($request->input('commonPhotos'));
        $orderUser->comment = $request->input('userQuestionsAnswer');
        $orderUser->design = array_key_first( $request->input('designChoice'));


        if ($orderUser->save()){
            return redirect()->route('orders.client.show', $orderTextLink )->with(['success'=>true]);
        }
        else {
            return back()->withErrors(['msg'=>'Ошибка сохранения'])->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        OrderUser::destroy($id);
        return redirect()->back();
    }

    /**
     * @param string $textLink
     * @return int orderId
     */
    protected function getOrderId($textLink){
        return Order::where('link_secret', '=', $textLink)->get(['id'])[0]->id;
    }

}
