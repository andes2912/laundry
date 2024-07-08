<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'API\AuthController@login');
Route::middleware('auth:sanctum')->group(function () {
    Route::get('list-laundry', 'API\OrderController@listLaundry');
    Route::get('list-harga', 'API\OrderController@listHarga');
    Route::get('list-transaksi', 'API\OrderController@listTransaksi');
    Route::post('order', 'API\OrderController@order');
});


// <?php

// use App\Http\Controllers\API\AuthController;
// use Illuminate\Support\Facades\Route;

// Route::controller(AuthController::class)->group(function () {
//     Route::post('/login', 'login');

//     Route::middleware('auth:sanctum')->group(function () {
//         Route::prefix('/profile')->group(function () {
//             Route::get('/', 'profile');
//             Route::post('/', 'update');
//         });

//         Route::post('/logout', 'logout');
//     });
// });
