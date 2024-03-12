<?php

use Illuminate\Support\Facades\Route;
use SushiMarket\Sbertips\Controllers\QrCodeController;
use SushiMarket\Sbertips\Controllers\RegisterController;
use SushiMarket\Sbertips\Controllers\SbertipsController;

Route::get('/sbertips', [SbertipsController::class, 'index'])->name('sbertips');
Route::get('/qrcode/list', [QrCodeController::class, 'list'])->name('qrcodeList');

Route::group(['prefix' => 'sbertips'], function() {
    Route::post('/clients/create', [RegisterController::class, 'clientsCreate'])->name('clientsCreate');
    Route::post('/auth/otp', [RegisterController::class, 'authOtp'])->name('authOtp');
    Route::post('/clients/info', [RegisterController::class, 'clientsInfo'])->name('clientsInfo');
});