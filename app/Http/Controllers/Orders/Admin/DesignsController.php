<?php

namespace App\Http\Controllers\Orders\Admin;

use App\Http\Controllers\Orders\BaseController;
use App\Jobs\TransferFullDirectoryDesignsToS3;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DesignsController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $diskClient=  Storage::disk('yadisk');
        }
        catch (\Exception $e){
            return view('orders.admin.designs.index')->withErrors([$e->getMessage()]);
        }

        $designs = $this->getDesignsFromS3($diskClient);

        return view('orders.admin.designs.index', compact('designs'));
    }

    /**
     * Sync YandexDisk and S3 storage
     *
     * @return \Illuminate\Http\Response
     */
    public function sync()
    {
        try{
            $diskClient = $this->initYandexDisk();
        }
        catch (\Exception $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }

        $designs = $this->getDesignsFromYandexDisk($diskClient);
        $totalDesigns = count($designs);
        $count = 0;
        foreach ($designs as $designPath){
            TransferFullDirectoryDesignsToS3::dispatch( $designPath );
            $count++;
        }

        //TODO  добавить счетчик сколько фотографий было добавлено на обработку и возвращать с запросом
        return redirect()->back();
    }

    /**
     * @return \Arhitector\Yandex\Disk
     * @throws \Exception
     */
    private function initYandexDisk(){
        $diskClient = new \Arhitector\Yandex\Disk( env('YANDEX_OAUTH'));
        $isValidation = $this->validateYandexDisk($diskClient, env('YANDEX_DESIGN_DIR') );

        if ($isValidation==true){
            return $diskClient;
        }
        else
            throw new \Exception($isValidation);
    }

    /**
     * @param \Arhitector\Yandex\Disk $diskClient
     * @param $path
     * @return bool true | string
     */
    public function validateYandexDisk($diskClient, $path){
        try{
            $diskClient->getResource( $path )->toObject() ;
            return true;
        }
        catch ( \Arhitector\Yandex\Client\Exception\NotFoundException $e) {
            Log::error('Не найдена папка с дизайнами');
            return "Не найдена папка с дизайнами";
        }
        catch (\Arhitector\Yandex\Client\Exception\UnauthorizedException $e){
            Log::error("Яндекс диск не доступен. Обратитесь к системному администратору, проверить токены приложения.");
            return 'Яндекс диск не доступен. Обратитесь к системному администратору, проверить токены приложения.';
        }
        catch (\Exception $e ) {
            Log::error("Ошибка при иницициализации диска. Проверьте корректность токенов приложения.");
            return "Ошибка при иницициализации диска. Проверьте корректность токенов приложения.";
        }
    }

    /**
     * get all designs from s3 storage
     * @param Illuminate\Support\Facades\Storage  $s3Client
     * @return array
     */
    public function getDesignsFromS3($s3Client)
    {
        $designsPath = env('YANDEX_DESIGN_DIR');
        $dirs = $s3Client->allDirectories( $designsPath );

        //превратится в двумерный массив [ string => [url, url, url] ]
        $designs = array();

        foreach ($dirs as $dir){
            $files = $s3Client->allFiles($dir);

            //Получаем из полного пути только название дизайна (последний раздел пути)
            $designName = explode('/', $dir);
            $designName = array_pop( $designName);

            //Формируем массив с ссылками на картинки
            $designs[$designName] = array();
            foreach ($files as $file){
                array_push($designs[$designName], $s3Client->url($file) );
            }
        }

        return  $designs;
    }

    /**
     * @param \Arhitector\Yandex\Disk $diskClient
     */
    public function getDesignsFromYandexDisk($diskClient){
        $designsPath = env('YANDEX_DESIGN_DIR');
        $dirs = $diskClient->getResource($designsPath)->toObject()->items;
        $designsFullPathArray = array();

        foreach ($dirs as $dir){
            $fullName = $designsPath."/$dir->name";
            array_push($designsFullPathArray, $fullName);
        }

        return $designsFullPathArray;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeDirectory(Request $request) {
        dd('На данный момент эта функция в разработке, вы можете изменять папку с дизайном через .env файл проекта');
        if( putenv('YANDEX_DESIGN_DIR', $request->input('designDir')) ){
            return redirect()->back();
        }
        else {
            return redirect()->back()->withErrors();
        }
    }


}
