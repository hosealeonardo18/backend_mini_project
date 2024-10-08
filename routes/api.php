<?php

use App\Http\Controllers\PelangganControllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// pelanggan
Route::get('/pelanggan', [PelangganControllers::class, 'index']);
Route::get('/pelanggan/{uid}', [PelangganControllers::class, 'show']);
Route::post('/pelanggan', [PelangganControllers::class, 'store']);
Route::put('/pelanggan/{uid}', [PelangganControllers::class, 'update']);
Route::delete('/pelanggan/{uid}', [PelangganControllers::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
