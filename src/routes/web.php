<?php

use Illuminate\Support\Facades\Route;
use SushiMarket\Sbertips\Controllers\SbertipsController;

Route::get('/sbertips', [SbertipsController::class, 'index'])->name('sbertips');
