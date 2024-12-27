<?php


use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckCodeMiddleware;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {

////////////////////////Auth/////////////////////////////////
    Route::post('/sendCode', [AuthController::class, 'sendCode'])
        ->name('auth.send_code');

    Route::post('/verifyCode', [AuthController::class, 'verifyCode'])
        ->middleware(CheckCodeMiddleware::class)
        ->name('auth.verifyCode');

});


