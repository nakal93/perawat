<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WilayahController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Indonesian Regional API Routes
Route::prefix('wilayah')->group(function () {
    Route::get('/provinsi', [WilayahController::class, 'getProvinsi']);
    Route::get('/kabupaten', [WilayahController::class, 'getKabupaten']);
    Route::get('/kecamatan', [WilayahController::class, 'getKecamatan']);
    Route::get('/kelurahan', [WilayahController::class, 'getKelurahan']);
    Route::get('/alamat-lengkap', [WilayahController::class, 'getAlamatLengkap']);
});
