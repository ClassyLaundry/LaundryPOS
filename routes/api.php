<?php

use App\Http\Controllers\CatatanPelangganController;
use App\Http\Controllers\ItemTransaksiController;
use App\Http\Controllers\JenisItemController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ParfumController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\TestingController;
use Illuminate\Http\Request;
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

Route::post('/ping', [TestingController::class, 'test']);
Route::post('/multi-image', [TestingController::class, 'testMultiImage']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Laporan
 */
Route::get('/mutasi-deposit', [LaporanController::class, 'mutasiDeposit']); //
Route::get('/mutasi-deposit-pelanggan', [LaporanController::class, 'mutasiDeposit']); // /mutasi-deposit?pelanggan_id=1&bulan=1&tahun=2023
Route::get('/kas-masuk', [LaporanController::class, 'kasMasuk']); // /kas-masuk?outlet_id=1&bulan=1&tahun=2023
Route::get('/semua-piutang', [LaporanController::class, 'semuaPiutang']); //
Route::get('/piutang-pelanggan', [LaporanController::class, 'piutangPelanggan']); // /piutang-pelanggan?pelanggan_id=1
Route::get('/omset-bulanan', [LaporanController::class, 'omsetBulanan']); // /omset-bulanan?bulan=1&tahun=2023

/**
 * Catatan Pelanggan
 */
Route::middleware(['auth'])->group(function () {
    Route::prefix('catatan-pelanggan')->group(function () {
        Route::get('/{pelanggan_id}', [CatatanPelangganController::class, 'getByPelangganID']);
        Route::post('/insert', [CatatanPelangganController::class, 'insert']);
        Route::post('/update', [CatatanPelangganController::class, 'update']);
    });
});
