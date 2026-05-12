<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
    ]);
});

Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show'])->whereNumber('id');
Route::patch('/orders/{id}', [OrderController::class, 'update'])->whereNumber('id');
Route::put('/orders/{id}', [OrderController::class, 'update'])->whereNumber('id');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->whereNumber('id');
Route::get('/orders/{id}/track', [OrderController::class, 'track'])->whereNumber('id');
