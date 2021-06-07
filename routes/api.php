<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login','Api\AuthController@login');
Route::post('logout','Api\AuthController@logout');
Route::get('verify-device','Api\AuthController@verifyDevice');

Route::get('produk', 'Api\ApiProdukController@getProduk');

Route::group(['middleware' => ['auth.api']], function () {

	Route::get('keranjang', 'Api\BookingController@cekKeranjang');
	Route::post('keranjang', 'Api\BookingController@addKeranjang');

	Route::post('cek-harga-harian', 'Api\BookingController@cekHargaHarian');

	Route::post('booking', 'Api\BookingController@setBooking');

});

Route::group(['middleware' => ['auth.api.admin']], function () {
	Route::post('scann', 'Api\ScannTransaksiController@scann');
});

Route::get('tentang', 'Api\ApiGaleriController@getTentang');
Route::get('petunjuk', 'Api\ApiGaleriController@getPetunjuk');
