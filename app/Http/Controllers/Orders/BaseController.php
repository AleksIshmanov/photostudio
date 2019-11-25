<?php

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

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
}
