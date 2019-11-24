<?php

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DesignsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $designs = $this->getDesigns();

        return view('orders.admin.designs.index', compact('designs'));
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
        if( putenv('YANDEX_DESIGN_DIR', $request->input('designDir')) ){
            return redirect()->back();
        }
        else {
            return redirect()->back()->withErrors();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function getDesigns()
    {
        $storage = Storage::disk('yadisk');
        $designsPath = env('YANDEX_DESIGN_DIR');
        $dirs = $storage->allDirectories( $designsPath );

        //превратится в двумерный массив [ string => [url, url, url] ]
        $designs = $dirs;

        foreach ($dirs as $dir){
            $designs[$dir] = $storage->allFiles( $designsPath.'/'.$dir );
        }

        return  $designs;
    }


}
