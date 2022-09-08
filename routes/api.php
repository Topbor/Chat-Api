<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\AuthController;
use \App\Http\Controllers\API\DutyController;

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


Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::delete('logout', [AuthController::class, 'logout']);
    Route::post('login/confirm', [AuthController::class, 'confirm']);
    Route::post('forgot/password', [AuthController::class, 'forgotPassword']);
    Route::post('message', [MessageController::class, 'create']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('duty', [DutyController::class, 'show_duties']);
        Route::post('duty/{duty_id}', [DutyController::class, 'begin_duty']);

        Route::post('event', [\App\Http\Controllers\API\EventController::class, 'create']);
        Route::get('event/{id}/{user_id}', [\App\Http\Controllers\API\EventController::class, 'setResponsible']);
        Route::get('chat/{id}', [DutyController::class, 'get_chat']);
        Route::get('user', [AuthController::class, 'user_with_duty']);
    });
});


Route::prefix('v2')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('event', [\App\Http\Controllers\API\EventController::class, 'createV2']);
        Route::get('event/{id}/{user_id}', [\App\Http\Controllers\API\EventController::class, 'setResponsibleV2']);

        Route::patch('/fcm-token', [AuthController::class, 'updateToken'])->name('fcmToken');
        Route::post('/send-notification',[MessageController::class,'create_with_notification'])->name('notification');
    });
});
