<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaxController;

Route::post('/max-init', [MaxController::class, 'validateMaxWebAppData']);
Route::post('/max-set-step', [MaxController::class, 'setStep']);

Route::post('/max/webhook', [MaxController::class, 'webhook']);
Route::get('/max/setWebhook', [MaxController::class, 'setWebhook']);
Route::get('/max/get-profile', [MaxController::class, 'getProfile']);

Route::post('/max/pay-tariff', [MaxController::class, 'payTariff']);
Route::post('/max/renew-tariff', [MaxController::class, 'renewTariff']);
Route::post('/max/autopaiment', [MaxController::class, 'enableAutoPayment']);
Route::post('/max/disable-autopaiment', [MaxController::class, 'disableAutoPayment']);

Route::post('/max/complete-test', [MaxController::class, 'completeTest']);