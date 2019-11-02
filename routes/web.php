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
    Route::get('order/{link_id}', 'OrderController@show')->name('orders.client.show');
    Route::post('order', 'Admin\OrderUserController@store')->name('orders.client.store');
});


$admin_options = [
    'namespace' => 'Orders',
    'middleware'=>'auth',
    'prefix' => 'photo_admin',
];
Route::group($admin_options, function() {
    Route::resource('order', 'OrderController')->names('orders.admin.order');
    Route::resource('user', 'Admin\OrderUserController')->names('orders.admin.user');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
