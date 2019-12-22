<?php

namespace App\Http\Controllers\Orders;

use App\Http\Requests\storeNewOrderAnswer;
use App\Models\OrderAnswers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientHelperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $answers = OrderAnswers::all();

        return view('orders.admin.questions.index', compact('answers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('orders.admin.questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeNewOrderAnswer $request)
    {

        $answer = new OrderAnswers();
        $answer->header = $request->input('header');

        $filtered_text = str_replace( array("\r\n", "\n"), '<br>', $request->input('text'));
        $answer->text = $filtered_text;

        return $answer->save() ? redirect()->back() : redirect()->back()->withErrors();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        OrderAnswers::destroy($id);

        return redirect()->back();
    }
}
