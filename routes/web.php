<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Orders'], function() {
    Route::get('order', 'OrderController@show')->name('show_order');
});


$admin_options = [
    'namespace' => 'Orders',
    'middleware'=>'auth',
    'prefix' => 'admin',
];
Route::group($admin_options, function() {
    Route::resource('order', 'OrderController')->names('order');
});
