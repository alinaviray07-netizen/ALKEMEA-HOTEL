<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoomApiController;
use App\Http\Controllers\Api\ReservationApiController;
use App\Http\Controllers\Api\PaymentApiController;

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

Route::get('/rooms', [RoomApiController::class, 'index']);
Route::get('/rooms/{room}', [RoomApiController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Admin Protected API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('admin.token')->group(function () {

    Route::post('/rooms', [RoomApiController::class, 'store']);
    Route::patch('/rooms/{room}', [RoomApiController::class, 'update']);
    Route::delete('/rooms/{room}', [RoomApiController::class, 'destroy']);

    Route::get('/reservations', [ReservationApiController::class, 'index']);
    Route::get('/reservations/{reservation}', [ReservationApiController::class, 'show']);
    Route::post('/reservations', [ReservationApiController::class, 'store']);
    Route::patch('/reservations/{reservation}', [ReservationApiController::class, 'update']);
    Route::delete('/reservations/{reservation}', [ReservationApiController::class, 'destroy']);

    Route::get('/payments', [PaymentApiController::class, 'index']);
    Route::get('/payments/{payment}', [PaymentApiController::class, 'show']);
    Route::post('/payments', [PaymentApiController::class, 'store']);
    Route::patch('/payments/{payment}', [PaymentApiController::class, 'update']);
    Route::delete('/payments/{payment}', [PaymentApiController::class, 'destroy']);

});