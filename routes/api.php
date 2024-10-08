<?php

use App\Http\Controllers\BarangControllers;
use App\Http\Controllers\PelangganControllers;
use App\Http\Controllers\PenjualanControllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// pelanggan
Route::get('/pelanggan', [PelangganControllers::class, 'index']);
Route::get('/pelanggan/{uid}', [PelangganControllers::class, 'show']);
Route::post('/pelanggan', [PelangganControllers::class, 'store']);
Route::put('/pelanggan/{uid}', [PelangganControllers::class, 'update']);
Route::delete('/pelanggan/{uid}', [PelangganControllers::class, 'destroy']);

// barang
Route::get('/barang', [BarangControllers::class, 'index']);
Route::get('/barang/{kode}', [BarangControllers::class, 'show']);
Route::post('/barang', [BarangControllers::class, 'store']);
Route::put('/barang/{kode}', [BarangControllers::class, 'update']);
Route::delete('/barang/{kode}', [BarangControllers::class, 'destroy']);

// penjualan
Route::get('/penjualan', [PenjualanControllers::class, 'index']);
Route::get('/penjualan/{nota}', [PenjualanControllers::class, 'show']);
Route::post('/penjualan', [PenjualanControllers::class, 'store']);
Route::put('/penjualan/{nota}', [PenjualanControllers::class, 'update']);
Route::delete('/penjualan/{nota}', [PenjualanControllers::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
