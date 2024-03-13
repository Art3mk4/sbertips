<?php

use Illuminate\Support\Facades\Route;
use SushiMarket\Sbertips\Controllers\QrCodeController;
use SushiMarket\Sbertips\Controllers\RegisterController;
use SushiMarket\Sbertips\Controllers\SbertipsController;

Route::group(['prefix' => 'sbertips'], function() {
    Route::post('/clients/create', [RegisterController::class, 'clientsCreate'])->name('clientsCreate');
    Route::post('/auth/otp', [RegisterController::class, 'authOtp'])->name('authOtp');
    Route::post('/auth/token', [RegisterController::class, 'authToken'])->name('authToken');
    Route::post('/clients/info', [RegisterController::class, 'clientsInfo'])->name('clientsInfo');


    Route::post('/qrcode/list', [QrCodeController::class, 'list'])->name('qrcodeList');
});
