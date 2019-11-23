<?php

use Illuminate\Support\Str;

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
    echo 'M' . str_pad(rand(0, pow(10, 3) - 1), 3, '0', STR_PAD_LEFT) . strtoupper(Str::random(1)) . rand(0, 9);
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
});
