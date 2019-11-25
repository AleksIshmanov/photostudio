<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Orders\Admin\DesignsController;
use App\Http\Requests\storeNewOrderRequest;
use App\Jobs\TransferFullDirectoryOrdersToS3;
use App\Models\OrderUserAnswer;
use App\Models\Order;
use App\Models\OrderUser;
use Cassandra\Table;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\Types\Null_;
use Yandex\DataSync\Responses\DatabaseDeltasResponse;

class OrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobsTable = DB::table('jobs');
        $totalJobsOnTransfer = $jobsTable->count();
        $totalAttempts = $jobsTable->where('attempts', '>', '3')->count();

        return view('orders.admin.order.index', compact('totalJobsOnTransfer', 'totalAttempts'))
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
         * Get all choices and count them
         *
         * @param int $order_id
         * @return array descended sort
         */
        private function countVotes($orderId ){
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
     * @param $textLink
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function choose($textLink){
        $photo = new PhotoController();
        $designs = new DesignsController();

        $portraitsPhoto = $photo->getPortraitsPhotos($textLink, 20);
        $groupsPhoto = $photo->getGroupsPhotos($textLink, 20);
        $order = Order::where('link_secret', '=', $textLink)->first();

        $portraitsPhoto = json_decode($portraitsPhoto->getContent(), true)['data'];
        $groupsPhoto = json_decode($groupsPhoto->getContent(), true)['data'];

        $designs = $designs->getDesignsFromS3();

        return view('orders.client.choose', compact('portraitsPhoto', 'groupsPhoto', 'order', 'textLink', 'designs'));
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

        //variable that uses twice and much
        $orderName = $request->input('taskName');
        $dirName = env('YANDEX_START_DIR') . '/'. $request->input('dirName');

        //get inputs params from view
        $order->name = $orderName;
        $order->portraits_count = $request->input('individualPhotosCount');
        $order->photo_common = $request->input('photosAll');
        $order->photo_individual = $request->input('commonPhotosToCustomer');
        $order->photos_link = $request->input('photoAlbumLink');
        $order->designs_count = $request->input('designsCount');
        $order->comment = $request->input('comment');
        $order->confirm_key = substr(md5(time()), 0, 3).mt_rand(1000, 9999) ;
        $order->link_secret =  substr(md5(time()), 0, 5).mt_rand(100, 999);

        $questionnaire = $request->input('questionnaire');
        if ( null != $questionnaire){
            $form = new OrderUserAnswer;
            $form->questions = $questionnaire;
            $form->save();
        }
        $order->photos_dir_name = $dirName;

        return  $this->_saveAndTransfer($dirName, $orderName, $order);
    }

        /**
         * Validate function for Transfer process and request
         *
         * @param string $dirName
         * @param string $orderName
         * @param Order $order
         * @return \Illuminate\Http\Response
         */
        private function _saveAndTransfer(string $dirName, string $orderName, Order $order){
            if ($order->save()){
                return $this->tryToDispatchTransferProcess( $dirName, false);
            }
            else {
                return redirect()->back()->withErrors()->withInput();
            }
        }

        /**
         * @param string $dirName
         * @param bool $isDesign Вызван ли данный метод для валидации папки с дизайнами
         * @return \Illuminate\Foundation\Bus\PendingDispatch|\Illuminate\Http\Response
         */
        public function tryToDispatchTransferProcess(string $dirName, bool $isDesign) {
            try {
                $diskClient= new \Arhitector\Yandex\Disk( env('YANDEX_OAUTH') );
                $diskClient->getResource($dirName)->toObject(); //ошибки выпадают только при физическом преобразовании объекта (метод ->toArray())
                Storage::disk('yadisk')->put('testConnection.txt', '0');

                //Для дизайна валидация папки не нужна
                if (!$isDesign){
                    $this->_isCorrectFormat($diskClient, $dirName);
                }

                //Если вся валидация пройдена - добавляем заказ в очередь на обработку
                TransferFullDirectoryOrdersToS3::dispatch(  $dirName );

            }
            catch (\Arhitector\Yandex\Client\Exception\UnauthorizedException $e){
                return $this->validationError(
                    "'Яндекс диск не доступен. Обратитесь к системному администратору, проверить токены приложения.",
                    "Яндекс диск: ".$e->getMessage(),
                    $e
                );
            }
            catch ( \Arhitector\Yandex\Client\Exception\NotFoundException $e) {
                return $this->validationError(
                    "Папка не найдена. Помните: пробелы, заглавные буквы и другие знаки влияют на название.",
                    "Яндекс диск: ".$e->getMessage(),
                    $e
                );
            }
            catch (\InvalidArgumentException $e) {
                return $this->validationError(
                    "Папка '$dirName' найдена, 
                    но все фотографии должны быть распределены по двум подпапкам \'ОБЩИЕ\' и \'ПОРТРЕТЫ\'.
                     Исправьте и повторите попытку",
                    null,
                    $e
                );
            }
            catch (\Exception $e ) {
                return $this->validationError(
                    "Ошибка при иницициализации диска. Проверьте корректность токенов приложения.",
                    'Storage exception '. __METHOD__. $e->getMessage(),
                    $e
                );
            }

            //Если все отработало нормально - возвращаем на страницу всех заказов
            return redirect()->route('orders.admin.order.index');
        }

        /**
         * Проверяем внутреннюю иерархию папки на корректность
         *
         * @param $diskClient
         * @param $dirName
         *
         * @throws \InvalidArgumentException
         */
        private function _isCorrectFormat($diskClient, $dirName) {
            //проверка на корректность форматирования папки
            try {
                $diskClient->getResource($dirName.'/ПОРТРЕТЫ')->toObject();
                $diskClient->getResource($dirName.'/ОБЩИЕ')->toObject();
            }
            catch (\Arhitector\Yandex\Client\Exception\NotFoundException $e) {
                throw new \InvalidArgumentException();
            }
        }
}
