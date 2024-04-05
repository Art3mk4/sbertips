<?php

use Illuminate\Support\Facades\Route;
use SushiMarket\Sbertips\Controllers\QrCodeController;
use SushiMarket\Sbertips\Controllers\RegisterController;
use SushiMarket\Sbertips\Controllers\SbertipsController;
use SushiMarket\Sbertips\Controllers\CardController;
use SushiMarket\Sbertips\Controllers\TransferController;

Route::prefix('sbertips')->middleware(['sbertips_auth'])->group(function() {
    Route::post('/client/registerStart', [RegisterController::class, 'registerStart'])->name('clientRegisterStart');
    Route::post('/client/registerFinish', [RegisterController::class, 'registerFinish'])->name('clientRegisterFinish');

    Route::post('/clients/create', [RegisterController::class, 'clientsCreate'])->name('clientsCreate');
    Route::post('/auth/otp', [RegisterController::class, 'authOtp'])->name('authOtp');
    Route::post('/auth/token', [RegisterController::class, 'authToken'])->name('authToken');
    Route::post('/clients/info', [RegisterController::class, 'clientsInfo'])->name('clientsInfo');

    Route::post('/qrcode/add', [QrCodeController::class, 'add'])->name('qrcodeAdd');
    Route::post('/qrcode/update', [QrCodeController::class, 'update'])->name('qrcodeUpdate');
    Route::post('/qrcode/delete', [QrCodeController::class, 'delete'])->name('qrcodeDelete');
    Route::post('/qrcode/get', [QrCodeController::class, 'get'])->name('qrcodeGet');
    Route::post('/qrcode/list', [QrCodeController::class, 'list'])->name('qrcodeList');

    Route::post('/savecard/start', [CardController::class, 'saveStart'])->name('saveStart');
    Route::post('/savecard/finish', [CardController::class, 'saveFinish'])->name('saveFinish');
    Route::post('/card/list', [CardController::class, 'list'])->name('cardList');
    Route::post('/card/active', [CardController::class, 'active'])->name('cardActive');
    Route::post('/card/delete', [CardController::class, 'delete'])->name('cardDelete');
    Route::post('/check/orders', [CardController::class, 'checkOrders'])->name('checkOrdersForTip');

    Route::post('/transferPayment', [TransferController::class, 'sbertipsPayment'])->name('sbertipsPayment');
    Route::post('/transfer/secure/register', [TransferController::class, 'secureRegister'])->name('secureRegister');
    Route::post('/transfer/secure/finish', [TransferController::class, 'secureFinish'])->name('secureFinish');
    Route::post('/transfer/payment', [TransferController::class, 'payment'])->name('payment');
});
