<?php

use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\TrucksController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle'])->withoutMiddleware([VerifyCsrfToken::class]);

Route::post('/truck-location/update', [TrucksController::class, 'storeTracking']);
