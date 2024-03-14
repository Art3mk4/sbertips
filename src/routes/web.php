<?php

use Illuminate\Support\Facades\Route;
use SushiMarket\Sbertips\Controllers\QrCodeController;
use SushiMarket\Sbertips\Controllers\RegisterController;
use SushiMarket\Sbertips\Controllers\SbertipsController;
use SushiMarket\Sbertips\Controllers\CardController;

Route::group(['prefix' => 'sbertips'], function() {
    Route::post('/clients/create', [RegisterController::class, 'clientsCreate'])->name('clientsCreate');
    Route::post('/auth/otp', [RegisterController::class, 'authOtp'])->name('authOtp');
    Route::post('/auth/token', [RegisterController::class, 'authToken'])->name('authToken');
    Route::post('/clients/info', [RegisterController::class, 'clientsInfo'])->name('clientsInfo');

    Route::post('/qrcode/add', [QrCodeController::class, 'add'])->name('qrcodeAdd');
    Route::post('/qrcode/update', [QrCodeController::class, 'update'])->name('qrcodeUpdate');
    Route::post('/qrcode/delete', [QrCodeController::class, 'delete'])->name('qrcodeDelete');
    Route::post('/qrcode/list', [QrCodeController::class, 'list'])->name('qrcodeList');

    Route::post('/savecard/start', [CardController::class, 'saveStart'])->name('saveStart');
    Route::post('/savecard/finish', [CardController::class, 'saveFinish'])->name('saveFinish');
    Route::post('/card/list', [CardController::class, 'list'])->name('cardList');
    Route::post('/card/active', [CardController::class, 'active'])->name('cardActive');
    Route::post('/card/delete', [CardController::class, 'delete'])->name('cardDelete');
});
