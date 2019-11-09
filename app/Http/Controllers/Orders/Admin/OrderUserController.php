<?php

namespace App\Http\Controllers\Orders\Admin;

use App\Http\Requests\storeOrderuserRequest;
use App\Models\Order;
use App\Models\OrderUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        return view('orders.admin.order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeOrderuserRequest $request)
    {

        $orderUser = new OrderUser();


        $orderUser->name = $request->input('userName') .' '. $request->input('userSurname');
        $orderUser->id_order = $this->getOrderId($request->input('textLink'));
        $orderUser->portrait_main = array_key_first($request->input('mainPhoto'));

        $orderUser->portraits = $this->makeCustomJson($request->input('altMainPhotos'));
        $orderUser->common_photos = $this->makeCustomJson($request->input('commonPhotos'));

        $orderUser->comment = $request->input('userQuestionsAnswer');

        if ($orderUser->save()){
            return redirect()->back()->with(['success'=>true]);
        }
//        else {
//            return back()->withErrors(['msg'=>'Ошибка сохранения'])->withInput();
//        }

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
