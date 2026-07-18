<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingApiController;
use App\Http\Controllers\Api\BusApiController;
use App\Http\Controllers\Api\RouteApiController;
use App\Http\Controllers\Api\ScheduleApiController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/buses', [BusApiController::class, 'index']);
    Route::get('/routes', [RouteApiController::class, 'index']);
    Route::get('/schedules', [ScheduleApiController::class, 'index']);

    Route::get('/bookings', [BookingApiController::class, 'index']);
    Route::post('/bookings', [BookingApiController::class, 'store']);
    Route::get('/bookings/{booking}', [BookingApiController::class, 'show']);
    Route::put('/bookings/{booking}', [BookingApiController::class, 'update']);
    Route::delete('/bookings/{booking}', [BookingApiController::class, 'destroy']);
});