<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'API\AuthController@login');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', 'API\AuthController@profile');
    Route::get('list-laundry', 'API\OrderController@listLaundry');
    Route::get('list-harga', 'API\OrderController@listHarga');
    Route::get('list-transaksi', 'API\OrderController@listTransaksi');
    Route::get('list-transaksi-kurir', 'API\OrderController@listTransaksiKurir');
    Route::get('detail-transaksi/{id}', 'API\OrderController@detailTransaksi');
    Route::post('order', 'API\OrderController@order');
    Route::get('detail-laundry/{id}', 'API\OrderController@detailLaundry');
    Route::post('pickup-laundry', 'API\OrderController@pickupLaundry');
    Route::put('payment', 'API\OrderController@payment');
});
