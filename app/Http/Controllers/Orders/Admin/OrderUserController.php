<?php

namespace App\Http\Controllers\Orders\Admin;

use App\Http\Requests\storeNewOrderUserRequest;
use App\Models\Order;
use App\Models\OrderUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class OrderUserController extends Controller
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

        $portraitsPhoto = $this->getFullImgUrl($user->portraits, $orderDirName,'ПОРТРЕТЫ');
        $groupsPhoto = $this->getFullImgUrl($user->common_photos, $orderDirName,'ОБЩИЕ');
        $designs = $this->getUserDesign( $user->design, DesignsController::getDesignsFromS3() );

        return view('orders.client.demo', compact('user', 'groupsPhoto', 'portraitsPhoto', 'designs'));
    }

    /**

     * @param string $jsonEncodedString
     * @param string $relativeS3Path _ WARRNING! full path like 'ROOT_PHOTO_DIR/PHOTO_DIR'
     * @param string $finalPart
     * @return array $imgArray with full url
     */
    private function getFullImgUrl(string $jsonEncodedString, string $relativeS3Path, string $finalPart){
        $imgArray = json_decode($jsonEncodedString, true)['nums'];

        //Составное имя, для поддержки и дизайнов и фотографий по env() параметрам
        $path = "$relativeS3Path";
        $path = strlen($finalPart)>0 ? $path.'/'.$finalPart : $path;

        foreach ($imgArray as $key=>$imgName){
            $url = Storage::disk('yadisk')->url($path)."/$imgName";
            $imgArray[$key] = $url;
        }

        return $imgArray;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $orderUser->portrait_main = array_key_first($request->input('mainPhotos'));
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($textLink)
    {
//        $id = Order::where('link_secret', '=', $textLink)->get(['id']);
//        $users = OrderUser::where('order_id', '=', $id)->get();
//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    /**
     * create custom json for array
     *
     * @param array $choices
     * @return false|string
     */
    protected function makeCustomJson($choices){
        $nums = array();
        if(is_array($choices) ){
            $nums['nums'] = array_keys($choices);
        }

        return json_encode($nums);
    }
}
