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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('pesan/{id}', 'PesanController@index')->name('pesan');
Route::post('pesan/{id}', 'PesanController@pesan')->name('pesan-barang');
Route::get('checkout', 'PesanController@checkout')->name('checkout-barang');
Route::delete('checkout/{id}', 'PesanController@delete')->name('checkout-delete');

Route::get('konfirmasi', 'PesanController@konfirmasi')->name('checkout-konfirmasi');