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

// Modul Admin
Route::resource('admin','AdminController');
    // Pengguna
    Route::get('adm','AdminController@adm');
    Route::get('kry','AdminController@kry');
    Route::get('kry-add','AdminController@addkry');

    // Customer
    Route::get('customer','AdminController@customer');
    Route::get('customer-add','AdminController@addcustomer');
    Route::post('customer-store','AdminController@storecustomer');
    Route::get('customer-edit/{id_customer}','AdminController@editcustomer');
    Route::put('customer-update/{id_customer}','AdminController@updatecustomer');
    Route::delete('customer-delete/{id_customer}','AdminController@deletecustomer');
    Route::get('jml-transaksi','AdminController@jmlTransaksi');

    // Data Laundri
    Route::get('data-transaksi','AdminController@datatransaksi');
    Route::get('data-harga','AdminController@dataharga');
    Route::post('harga-store','AdminController@hargastore');
    Route::get('edit-harga','AdminController@hargaedit');

    // Laporan
    Route::get('invoice-customer/{id}','AdminController@invoice');

    // Notifikasi
    Route::get('notif','AdminController@notif');

// Modul Karyawan
Route::resource('pelayanan','PelayananController');
    // Transaksi
    Route::get('add-order/{id_customer}','PelayananController@addorders');
    Route::post('add-order-store/{id_customer}','PelayananController@addorderstore');
    Route::get('ubah-status-order','PelayananController@ubahstatusorder');
    Route::get('ubah-status-bayar','PelayananController@ubahstatusbayar');
    Route::get('ubah-status-ambil','PelayananController@ubahstatusambil');

    // Customer
    Route::get('list-customer','PelayananController@listcs');
    Route::get('list-customer-add','PelayananController@listcsadd');
    Route::post('list-costomer-store','PelayananController@addcs');

    // Filter
    Route::get('listharga','PelayananController@listharga');
    Route::get('listhari','PelayananController@listhari');

    // Laporan
    Route::get('invoice-kar/{id}','PelayananController@invoicekar');
    Route::get('cetak-invoice/{id}/print','PelayananController@cetakinvoice');
