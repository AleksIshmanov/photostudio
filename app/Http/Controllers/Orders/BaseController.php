<?php

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

}
