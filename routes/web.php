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



Route::bind('id', function ( $id ) {
	$decoded = \Hashids::decode($id);
	return count($decoded) > 0 ? $decoded[0] : false;
});


Route::get('/storage-link', function() {
	$exitCode = Artisan::call('storage:link');
});
Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:clear');
    
    return 'cleared!';
});

Route::get('admin', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('login/proses', 'Auth\LoginController@login')->name('login.proses');

Route::group(['middleware' => ['auth.admin'], 'prefix' => 'admin', 'as' => 'admin.' , 'namespace' => 'Admin'], function () {
	/*
	|--------------------------------------------------------------------------
	| Dashboard Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

	/*
	|--------------------------------------------------------------------------
	| Kategori Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::get('kategori', 'KategoriController@index')->name('kategori.index');
	Route::get('kategori/create', 'KategoriController@create')->name('kategori.create');
	Route::post('kategori/store', 'KategoriController@store')->name('kategori.store');
	Route::get('kategori/{id}/edit', 'KategoriController@edit')->name('kategori.edit');
	Route::put('kategori/{id}/edit', 'KategoriController@update')->name('kategori.update');
	Route::patch('kategori/delete/{id}', 'KategoriController@delete')->name('kategori.delete');
	Route::delete('kategori/delete/{id}', 'KategoriController@destroy')->name('kategori.destroy');
	Route::post('kategori/restore/{id}', 'KategoriController@restore')->name('kategori.restore');

	/*
	|--------------------------------------------------------------------------
	| Lapang Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::get('lapang', 'LapangController@index')->name('lapang.index');
	Route::get('lapang/create', 'LapangController@create')->name('lapang.create');
	Route::post('lapang/store', 'LapangController@store')->name('lapang.store');
	Route::get('lapang/{id}/edit', 'LapangController@edit')->name('lapang.edit');
	Route::put('lapang/{id}/edit', 'LapangController@update')->name('lapang.update');
	Route::patch('lapang/delete/{id}', 'LapangController@delete')->name('lapang.delete');
	Route::delete('lapang/delete/{id}', 'LapangController@destroy')->name('lapang.destroy');
	Route::post('lapang/restore/{id}', 'LapangController@restore')->name('lapang.restore');

	/*
	|--------------------------------------------------------------------------
	| Paket Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::get('paket', 'PaketController@index')->name('paket.index');
	Route::get('paket/create', 'PaketController@create')->name('paket.create');
	Route::post('paket/store', 'PaketController@store')->name('paket.store');
	Route::get('paket/{id}/edit', 'PaketController@edit')->name('paket.edit');
	Route::put('paket/{id}/edit', 'PaketController@update')->name('paket.update');
	Route::patch('paket/delete/{id}', 'PaketController@delete')->name('paket.delete');
	Route::delete('paket/delete/{id}', 'PaketController@destroy')->name('paket.destroy');
	Route::post('paket/restore/{id}', 'PaketController@restore')->name('paket.restore');

	/*
	|--------------------------------------------------------------------------
	| Booking Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::get('booking', 'BookingController@index')->name('booking.index');
	Route::get('booking/{id}/proses', 'BookingController@proses')->name('booking.proses');
	Route::patch('booking/delete/{id}', 'BookingController@delete')->name('booking.delete');
	Route::delete('booking/delete/{id}', 'BookingController@destroy')->name('booking.destroy');
	Route::post('booking/restore/{id}', 'BookingController@restore')->name('booking.restore');

	/*
	|--------------------------------------------------------------------------
	| Member Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::get('member', 'MemberController@index')->name('member.index');
	Route::get('member/{id}/proses', 'MemberController@proses')->name('member.proses');
	Route::patch('member/delete/{id}', 'MemberController@delete')->name('member.delete');
	Route::delete('member/delete/{id}', 'MemberController@destroy')->name('member.destroy');
	Route::post('member/restore/{id}', 'MemberController@restore')->name('member.restore');

	/*
	|--------------------------------------------------------------------------
	| Diklat Routes
	|--------------------------------------------------------------------------
	|
	*/
	Route::get('diklat', 'DiklatController@index')->name('diklat.index');
	Route::get('diklat/{id}/proses', 'DiklatController@proses')->name('diklat.proses');
	Route::patch('diklat/delete/{id}', 'DiklatController@delete')->name('diklat.delete');
	Route::delete('diklat/delete/{id}', 'DiklatController@destroy')->name('diklat.destroy');
	Route::post('diklat/restore/{id}', 'DiklatController@restore')->name('diklat.restore');

	/*
	Route::get('booking/create', 'BookingController@create')->name('booking.create');
	Route::post('booking/store', 'BookingController@store')->name('booking.store');
	Route::get('booking/{id}/edit', 'BookingController@edit')->name('booking.edit');
	Route::put('booking/{id}/edit', 'BookingController@update')->name('booking.update');
	*/

});


Route::get('/', 'Customer\HomeController@index')->name('home');
Route::get('/paket', 'Customer\PaketController@index')->name('paket');
Route::get('/paket-detail/{id}', 'Customer\PaketController@paketDetail')->name('paket.detail');
Route::get('/pelatihan', 'Customer\PelatihanController@index')->name('pelatihan');
/*
|--------------------------------------------------------------------------
| Auth Login Customer Routes
|--------------------------------------------------------------------------
|
*/
Route::get('login', 'Customer\LoginController@showLoginForm')->name('login.customer');
Route::get('logout-proses', 'Customer\LoginController@logout')->name('logout.customer');
Route::post('login-proses', 'Customer\LoginController@login')->name('login.customer.proses');
Route::get('verifikasi', 'Customer\LoginController@verifikasi')->name('verifikasi.akun');

/*
|--------------------------------------------------------------------------
| Auth Register Customer Routes
|--------------------------------------------------------------------------
|
*/
Route::get('daftar', 'Customer\DaftarController@index')->name('daftar.customer');
Route::post('daftar-proses', 'Customer\DaftarController@daftar')->name('daftar.customer.proses');
Route::get('daftar-verifikasi', 'Customer\DaftarController@kirimEmail')->name('daftar.customer.verifikasi');
Route::get('daftar/kirimulang', 'Customer\DaftarController@kirimUlang')->name('kirimulang.verifikasi');
Route::get('verifikasi-proses/{id}', 'Customer\DaftarController@verifikasi')->name('customer.verifikasi.proses');

Route::group(['middleware' => ['auth.user']], function () {

	Route::get('/transaksi', 'Customer\TransaksiController@index')->name('transaksi');
	Route::delete('/transaksi/delete/{id}', 'Customer\TransaksiController@delete')->name('transaksi.delete');
	Route::post('/upload-bukti', 'Customer\TransaksiController@upload')->name('upload.bukti');

	Route::get('/paket-beli/{id}', 'Customer\TransaksiController@beliPaket')->name('paket.beli');
	Route::get('/ketersediaan-booking', 'Customer\TransaksiController@getKetersediaanBooking')->name('ketersediaan-booking');
	Route::get('/end-time', 'Customer\TransaksiController@getEndTime')->name('get-end-time');
	Route::get('/end-date', 'Customer\TransaksiController@getEndDate')->name('get-end-date');
	Route::get('/get-jadwal', 'Customer\TransaksiController@getJadwal')->name('get-jadwal');
	Route::get('/cek-tanggal-berakhir-diklat', 'Customer\TransaksiController@cekTanggalBerakhirDiklat')->name('cek-tanggal-berakhir-diklat');
	Route::post('/booking', 'Customer\TransaksiController@booking')->name('booking');

	Route::get('/jadwal', 'Customer\JadwalController@index')->name('jadwal');
});





