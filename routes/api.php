<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\TariffsController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\PromocodesController;
use App\Http\Controllers\Admin\PaymentsController;
use App\Http\Controllers\Admin\TextsController;
use App\Http\Controllers\Admin\OptionsController;
use App\Http\Controllers\Admin\MailingController;
use App\Http\Controllers\Admin\SubscriptionsController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\FilesController;
use App\Consts\Permissions;
use Illuminate\Support\Facades\Route;

Route::as('.')->group(function(){

    Route::as('auth.')->prefix('/auth')->group(function(){
        Route::post('/login', [AuthController::class, 'login'])->name('login');

        Route::middleware('auth:admin')->group(function(){
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        });

    });

    Route::middleware('auth:admin')->group(function () {

        /**
         * Профиль
         */
        Route::prefix('/profile')->as('profile.')->group(function(){
            Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password');
        });

        /**
         * 2FA Google
         */
        Route::prefix('/tfa')->as('tfa.')->group(function(){

            Route::post('/generate', [ProfileController::class, 'generateTFA'])->name('generate');
            Route::post('/confirm', [ProfileController::class, 'confirmTFA'])->name('confirm');

            Route::middleware('two-factor:admin')->group(function(){
                Route::post('/remove', [ProfileController::class, 'removeTFA'])->name('remove');
            });

        });

        /**
         * Роли
         */
        Route::prefix('/roles')->as('roles.')->middleware('permissions:' . Permissions::GOVERNMENT)->group(function(){

            Route::post('/list', [RolesController::class, 'list'])->name('list');
            Route::post('/create', [RolesController::class, 'create'])->name('create');
            Route::post('/edit/{role}', [RolesController::class, 'edit'])->name('edit');
            Route::post('/remove/{role}', [RolesController::class, 'remove'])->name('remove');

        });

        /**
         * Администраторы
         */
        Route::prefix('/admins')->as('admins.')->middleware('permissions:' . Permissions::GOVERNMENT)->group(function(){

            Route::post('/list', [AdminsController::class, 'list'])->name('list');
            Route::post('/create', [AdminsController::class, 'create'])->name('create');
            Route::post('/edit/{admin}', [AdminsController::class, 'edit'])->name('edit');
            Route::post('/remove-two-factory/{admin}', [AdminsController::class, 'removeTwoFactory'])->name('remove-two-factory');
            Route::post('/remove/{admin}', [AdminsController::class, 'remove'])->name('remove');

        });


        /**
         * Пользователи
         */
        Route::prefix('/users')->as('users.')->middleware('permissions:' . Permissions::USERS)->group(function(){

            Route::post('/list', [UsersController::class, 'list'])->name('list');

            Route::post('/edit/{user}', [UsersController::class, 'edit'])->name('edit');
            Route::post('/set-banned/{user}', [UsersController::class, 'setBanned'])->name('set-banned');
            Route::post('/set-test-completed/{user}', [UsersController::class, 'setTestCompleted'])->name('set-test-completed');
            Route::post('/change-balance/{user}/{fund}', [UsersController::class, 'changeBalance'])->name('change-balance');

            Route::post('/invite-second-stair/{user}', [UsersController::class, 'inviteSecondStair'])->name('invite-second-stair');
            Route::post('/invite-third-stair/{user}', [UsersController::class, 'inviteThirdStair'])->name('invite-third-stair');
            Route::post('/invite-third-stair-testing/{user}', [UsersController::class, 'inviteThirdStairTesting'])->name('invite-third-stair-testing');
            Route::post('/send-offer/{user}', [UsersController::class, 'sendOffer'])->name('send-offer');
            Route::post('/kick/{user}', [UsersController::class, 'kick'])->name('kick');
            Route::post('/remove/{user}', [UsersController::class, 'remove'])->name('remove');

        });

        /**
         * Тарифы
         */
        Route::prefix('/tariffs')->as('tariffs.')->middleware('permissions:' . Permissions::TARIFFS)->group(function(){

            Route::post('/list', [TariffsController::class, 'list'])->name('list');
            Route::post('/create', [TariffsController::class, 'create'])->name('create');
            Route::post('/edit/{tariff}', [TariffsController::class, 'edit'])->name('edit');
            Route::post('/remove/{tariff}', [TariffsController::class, 'remove'])->name('remove');

            Route::post('/set-active/{tariff}', [TariffsController::class, 'setActive'])->name('set-active');

        });

        /**
         * Промокоды
         */
        Route::prefix('/promocodes')->as('promocodes.')->middleware('permissions:' . Permissions::PROMOCODES)->group(function(){

            Route::post('/list', [PromocodesController::class, 'list'])->name('list');
            Route::post('/create', [PromocodesController::class, 'create'])->name('create');
            Route::post('/edit/{promocode}', [PromocodesController::class, 'edit'])->name('edit');
            Route::post('/remove/{promocode}', [PromocodesController::class, 'remove'])->name('remove');

        });

        /**
         * Подписки
         */
        Route::prefix('/subscriptions')->as('subscriptions.')->middleware('permissions:' . Permissions::USERS)->group(function(){

            Route::post('/edit/{subscription}', [SubscriptionsController::class, 'edit'])->name('edit');
            Route::post('/cancel/{subscription}', [SubscriptionsController::class, 'cancel'])->name('cancel');


        });

        /**
         * Промокоды
         */
        Route::prefix('/payments')->as('payments.')->middleware('permissions:' . Permissions::PAYMENTS)->group(function(){

            Route::post('/list', [PaymentsController::class, 'list'])->name('list');

        });

        /**
         * Текста
         */
        Route::prefix('/texts')->as('texts.')->middleware('permissions:' . Permissions::TEXTS)->group(function(){

            Route::post('/edit/{text}', [TextsController::class, 'edit'])->name('edit');
            Route::post('/edit-hint/{text}', [TextsController::class, 'editHint'])->name('edit-hint');


        });

        /**
         * Переменные
         */
        Route::prefix('/options')->as('options.')->middleware('permissions:' . Permissions::OPTIONS)->group(function(){

            Route::post('/edit/{option}', [OptionsController::class, 'edit'])->name('edit');

        });

        /**
         * Статистик
         */
        Route::prefix('/statistic')->as('statistic.')->middleware('permissions:' . Permissions::STATISTIC)->group(function(){

            Route::post('/', [StatisticController::class, 'statistic'])->name('global');

        });

        /**
         * Рассылка
         */
        Route::prefix('/mailing')->as('mailing.')->middleware('permissions:' . Permissions::MAILING)->group(function(){

            Route::post('/list', [MailingController::class, 'list'])->name('list');
            Route::post('/create', [MailingController::class, 'create'])->name('create');
            Route::post('/pause/{mailing}', [MailingController::class, 'pause'])->name('pause');
            Route::post('/stop/{mailing}', [MailingController::class, 'stop'])->name('stop');
            Route::post('/play/{mailing}', [MailingController::class, 'play'])->name('play');


        });

        /**
         * Прогревочные посты
         */
        Route::prefix('/posts')->as('posts.')->middleware('permissions:' . Permissions::MAILING)->group(function(){

            Route::post('/create', [PostsController::class, 'create'])->name('create');
            Route::post('/set-indexes', [PostsController::class, 'setIndexes'])->name('set-indexes');
            Route::post('/edit-delay/{post}', [PostsController::class, 'editDelay'])->name('edit-delay');
            Route::post('/edit-content/{post}', [PostsController::class, 'editContent'])->name('edit-content');
            Route::post('/remove/{post}', [PostsController::class, 'remove'])->name('remove');


        });

        /**
         * Файлы
         */
        Route::prefix('/files')->as('files.')->group(function(){

            Route::post('/upload', [FilesController::class, 'upload'])->name('upload');
            Route::get('/get/{file}', [FilesController::class, 'get'])->name('get');

        });


    });
});

