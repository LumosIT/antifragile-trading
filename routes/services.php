<?php

use App\Http\Controllers\TelegramController;
use App\Http\Controllers\MaxController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CloudPaymentsController;

Route::post('/telegram/webhook', [TelegramController::class, 'webhook'])->name('telegram.webhook');
Route::post('/max/webhook', [MaxController::class, 'webhook'])->name('max.webhook');
Route::get('/max/setWebhook', [MaxController::class, 'webhook'])->name('max.webhook');

Route::get('/telegram/set-webhook', [TelegramController::class, 'setWebhook'])->name('telegram.set-webhook');

Route::post('/cloud-payments/webhook', [CloudPaymentsController::class, 'webhook'])->name('cloud-payments.webhook');
