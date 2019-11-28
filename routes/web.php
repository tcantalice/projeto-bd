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

Route::get('/', 'HomeController')->name('home');
/* Route::get('/', function() {
    $in = Carbon::createFromTime(12, 30, 22, 'America/Bahia');
    $out = Carbon::createFromTime(14, 20, 11, 'America/Bahia');

    echo $in->diffInHours($out);
}); */

// Mensalista
Route::group(['prefix' => '/mensalista'], function() {
    Route::get('/', 'ClienteMensalistaController@index')->name('mensalista');
    Route::get('/search', 'ClienteMensalistaController@search')->name('mensalista.search');
    Route::get('/create', 'ClienteMensalistaController@create')->name('mensalista.create');
    Route::post('/store', 'ClienteMensalistaController@store')->name('mensalista.store');
    Route::get('/edit', 'ClienteMensalistaController@edit')->name('mensalista.edit');
    Route::post('/update', 'ClienteMensalistaController@update')->name('mensalista.update');
    Route::get('/delete', 'ClienteMensalistaController@delete')->name('mensalista.delete');
    Route::delete('/destroy', 'ClienteMensalistaController@destroy')->name('mensalista.destroy');
});

Route::group(['prefix' => '/voucher'], function(){
    Route::get('/mensalista', 'VoucherController@mensalista')->name('voucher.mensalista');
    Route::get('/horista', 'VoucherController@horista')->name('voucher.horista');
    Route::post('/horista/generate', 'VoucherController@gen4Horista')->name('voucher.horista.generate');
    Route::post('/mensalista/generate', 'VoucherController@gen4Mensalista')->name('voucher.mensalista.generate');
    Route::get('/show', 'VoucherController@show')->name('voucher.show');
    Route::post('/close/{voucherId}', 'VoucherController@close')->name('voucher.close');
});

Route::get('/vagas', 'VagaController@index')->name('vagas');
Route::get('/vagas/search', 'VagaController@search')->name('vagas.search');
