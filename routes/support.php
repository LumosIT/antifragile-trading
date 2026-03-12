<?php

use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Route;

Route::get('set-webhook', [SupportController::class, 'setWebhook']);
Route::post('webhook', [SupportController::class, 'webhook']);

Route::get('page', [SupportController::class, 'index']);
Route::post('get-dialogs', [SupportController::class, 'getDialogs']);
Route::post('get-messages', [SupportController::class, 'getMessages']);
Route::post('get-undread-messages', [SupportController::class, 'unreadCounter']);
Route::post('send-message', [SupportController::class, 'sendMessage']);