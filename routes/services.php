<?php

use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CloudPaymentsController;

Route::post('/telegram/webhook', [TelegramController::class, 'webhook'])->name('telegram.webhook');

Route::get('/telegram/set-webhook', [TelegramController::class, 'setWebhook'])->name('telegram.set-webhook');

Route::post('/cloud-payments/webhook', [CloudPaymentsController::class, 'webhook'])->name('cloud-payments.webhook');
