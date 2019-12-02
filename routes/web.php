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
    Route::get('order/{link_id}/choose', 'OrderController@choose')->name('orders.client.choose');

    //User controllers client
    Route::post('order', 'Admin\OrderUserController@store')->name('orders.client.store');
    Route::get('order/{link_id}/confirm', 'OrderConfirmController@index')->name('orders.client.confirm');
    Route::post('order/{link_id}/confirm', 'OrderConfirmController@finalConfirm')->name('orders.client.confirm.post');
    Route::get('order/{link_id}/{user_id}', 'Admin\OrderUserController@index')->name('orders.client.user.demo');

    //photos
    Route::get('photo/portraits/{order_text_link}/{count}', 'PhotoController@getGroupsPhotos')->name('orders.photos.portrait');
    Route::get('photo/groups/{order_text_link}/{count}', 'PhotoController@getPortraitsPhotos')->name('orders.photos.group');
});


$admin_options = [
    'namespace' => 'Orders',
    'prefix' => 'photo_admin',
];
Route::group($admin_options, function() {
    Route::resource('order', 'OrderController')->names('orders.admin.order')->middleware('auth');
    Route::resource('user', 'Admin\OrderUserController')->names('orders.admin.user');

    //designs
    Route::post('designs', 'Admin\DesignsController@changeDirectory')->name('orders.admin.designs.config')->middleware('auth');
    Route::get('designs', 'Admin\DesignsController@index')->name('orders.admin.designs.index')->middleware('auth');
    Route::post('designs/sync', 'Admin\DesignsController@sync')->name('orders.admin.designs.sync')->middleware('auth');
});

$photo_options = [
    'namespace' => 'Orders',
    'prefix' => ''
];

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
