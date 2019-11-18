<?php

namespace App\Http\Controllers\Orders;

use App\Http\Requests\storeNewOrderRequest;
use App\Jobs\TransferYandexToS3;
use App\Models\OrderUserAnswer;
use App\Models\Order;
use App\Models\OrderUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('orders.admin.order.index')
            ->with(['paginator' => Order::orderBy('updated_at', 'desc')
                ->paginate(20),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.admin.order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeNewOrderRequest $request)
    {
        $order = new Order;

        //get inputs params from view
        $order->name = $request->input('taskName');
        $order->portraits_count = $request->input('individualPhotosCount');
        $order->photo_common = $request->input('photosAll');
        $order->photo_individual = $request->input('commonPhotosToCustomer');
        $order->photos_link = $request->input('photoAlbumLink');
        $order->designs_count = $request->input('designsCount');
        $order->comment = $request->input('comment');
        $order->confirm_key = substr(md5(time()), 0, 3).mt_rand(1000, 9999) ;
        $order->link_secret =  substr(md5(time()), 0, 5).mt_rand(100, 999);

        $order->photos_dir_name = $request->input('dirName');

        $questionnaire = $request->input('questionnaire');
        if ( null != $questionnaire){
            $form = new OrderUserAnswer;
            $form->questions = $questionnaire;
            $form->save();
        }

        try{
            TransferYandexToS3::dispatch( $request->input('dirName') )->delay(now()->addMinutes(5));
            if ($order->save()){
                return redirect()->route('orders.admin.order.index');
            }
            else {
                return redirect()->back()->withErrors()->withInput();
            }

        }
        catch (\Arhitector\Yandex\Client\Exception\UnauthorizedException $e){
            Log::error("Яндекс диск: ".$e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(
                    [ 'Ошибка доступа к диску: '. $e->getMessage()]
                );
        }
        catch ( \Arhitector\Yandex\Client\Exception\NotFoundException $e) {
            Log::error("Яндекс диск: ".$e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(
                    [$e->getMessage()]
                );
        }
        catch (\Exception $e ) {
            Log::error('Storage exception: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(
                    [$e->getMessage()]
                );
        }
    }

    /**
     * Display the order for client
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($text_link)
    {
        $order = Order::where('link_secret', '=', $text_link)->get()[0];
        $users = OrderUser::where('id_order', '=', $order->id)->get();

        return view('orders.client.index', compact('order', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($order_id)
    {
        $users = OrderUser::where('id_order', '=', $order_id)->paginate(20);
        $choice = $this->countVotes($order_id);
//        $data = [$users, $choice];

        return view('orders.admin.order.edit', compact('users', 'choice' ));
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
        //+
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::destroy($id);
        return redirect()->back();
    }


    /**
     * Get all choices and count them
     *
     * @param int $order_id
     * @return array descended sort
     */
    public function countVotes($orderId ){
        $choice = [];

        //декодирование информации
        $common_photos =  OrderUser::where('id_order', '=', $orderId)->get(['common_photos']);
        foreach ($common_photos as $person_choice){
            $person_choice =json_decode($person_choice['common_photos'], true);
            if (isset($person_choice['nums'])){
                foreach ($person_choice['nums'] as $num){
                    $choice[$num] = isset($choice[$num]) ? $choice[$num]+1 : 1;
                }
            }
        }

        arsort($choice);
        return $choice;
    }


    /**
     * @param $textLink
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function choose($textLink){
        $photo = new PhotoController();
        $portraitsPhoto = $photo->getPortraitsPhotos($textLink, 20);
//        $groupsPhoto = $photo->getGroupsPhotos($textLink, 20);
        $order = Order::where('link_secret', '=', $textLink)->first();

        $portraitsPhoto = json_decode($portraitsPhoto->getContent(), true)['data'];
//        $groupsPhoto = json_decode($groupsPhoto->getContent(), true)['data'];

        return view('orders.client.choose', compact('portraitsPhoto', 'groupsPhoto', 'order'));
    }

}
