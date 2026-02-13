<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;

Route::as('.')->group(function () {

    Route::middleware('auth:user')->group(function () {

        Route::prefix('/pre-registration')->as('pre-registration')->group(function () {
            Route::get('/', [PublicController::class, 'preRegistration']);
            Route::post('/', [PublicController::class, 'preRegistrationForm']);
        });

        Route::prefix('/pay/{order}')->as('pay')->group(function () {
            Route::get('/', [PublicController::class, 'pay']);
            Route::post('/', [PublicController::class, 'payForm']);
        });

    });

    Route::get('/redirect', [PublicController::class, 'redirect'])->name('redirect');

});
