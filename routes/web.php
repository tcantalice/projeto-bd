<?php

use Carbon\Carbon;
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

Route::get('/', 'HomeController');
/* Route::get('/', function() {
    $in = Carbon::createFromTime(12, 30, 22, 'America/Bahia');
    $out = Carbon::createFromTime(14, 20, 11, 'America/Bahia');

    echo $in->diffInHours($out);
}); */

Route::group(['prefix' => '/mensalista'], function() {
    Route::get('/search', 'ClienteMensalistaController@search')->name('mensalista.search');
});

Route::group(['prefix' => '/voucher'], function(){
    Route::get('/', 'VoucherController@index')->name('voucher');
    Route::get('/mensalista', 'VoucherController@mensalista')->name('voucher.mensalista');
    Route::get('/horista', 'VoucherController@horista')->name('voucher.horista');
    Route::post('/generate/{tipoCliente}', 'VoucherController@generate')->name('voucher.generate');
    Route::get('/show', 'VoucherController@show')->name('voucher.show');
    Route::post('/close/{voucherId}', 'VoucherController@close')->name('voucher,close');
});
