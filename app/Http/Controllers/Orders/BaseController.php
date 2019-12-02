<?php

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BaseController extends Controller
{

    /** success response method.
     * @param string
     * @param array with errors
     * @param int status
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result)
    {
        $response = [
            'success' => true,
            'data' => $result,
        ];
        return response()->json($response, 200);
    }

    /**
     * @param string $userMessage
     * @param string|null $logMessage
     * @param  \Exception $error Любая ошибка расширяющая \Exception
     * @return \Illuminate\Http\Response
     */
    public function validationError(string $userMessage, string $logMessage, $error){

        if($logMessage!=null)
            Log::error($logMessage . $error->getMessage());

        return redirect()
            ->back()
            ->withInput()
            ->withErrors($userMessage);
    }


    /**

     * @param string $jsonEncodedString
     * @param string $relativeS3Path _ WARRNING! full path like 'ROOT_PHOTO_DIR/PHOTO_DIR'
     * @param string $finalPart
     * @return array $imgArray with full url
     */
    public function getFullImgUrlFromJson(string $jsonEncodedString, string $relativeS3Path, string $finalPart){
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
