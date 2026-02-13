<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ViewsController;
use Illuminate\Support\Facades\Route;
use App\Consts\Permissions;

Route::get('/', function(){
    return redirect()->route('admin.profile');
});

Route::as('.')->group(function(){

    Route::middleware('guest:admin')->group(function(){
        Route::get('/login', [ViewsController::class, 'login'])->name('login');
    });

    Route::middleware('auth:admin')->group(function () {

        /**
         * Профиль
         */
        Route::get('/profile', [ViewsController::class, 'profile'])->name('profile');

        /**
         * Роли
         */
        Route::as('roles')->prefix('/roles')->middleware('permissions:' . Permissions::GOVERNMENT)->group(function(){

            Route::get('/', [ViewsController::class, 'roles']);

            Route::as('.')->group(function(){
                Route::get('/create', [ViewsController::class, 'rolesCreate'])->name('create');
                Route::get('/edit/{role}', [ViewsController::class, 'rolesEdit'])->name('edit');
            });

        });

        /**
         * Администраторы
         */
        Route::as('admins')->prefix('/admins')->middleware('permissions:' . Permissions::GOVERNMENT)->group(function(){

            Route::get('/', [ViewsController::class, 'admins']);

            Route::as('.')->group(function() {

                Route::get('/create', [ViewsController::class, 'adminsCreate'])->name('create');
                Route::get('/edit/{admin}', [ViewsController::class, 'adminsEdit'])->name('edit');

            });

        });

        /**
         * Пользователи
         */
        Route::as('users')->prefix('/users')->middleware('permissions:' . Permissions::USERS)->group(function(){

            Route::get('/', [ViewsController::class, 'users']);

            Route::as('.')->group(function() {

                Route::get('/edit/{user}', [ViewsController::class, 'usersEdit'])->name('edit');

            });

        });

        /**
         * Тарифы
         */
        Route::as('tariffs')->prefix('/tariffs')->middleware('permissions:' . Permissions::TARIFFS)->group(function(){

            Route::get('/', [ViewsController::class, 'tariffs']);

            Route::as('.')->group(function() {

                Route::get('/create', [ViewsController::class, 'tariffsCreate'])->name('create');
                Route::get('/edit/{tariff}', [ViewsController::class, 'tariffsEdit'])->name('edit');

            });

        });

        /**
         * Прогревочные посты
         */
        Route::as('posts')->prefix('/posts')->middleware('permissions:' . Permissions::MAILING)->group(function(){

            Route::get('/', function(){
                return redirect()->route('admin.posts.type', \App\Consts\PostTypes::FIRST_STAIR);
            });

            Route::as('.')->group(function() {
                Route::get('/{type}', [ViewsController::class, 'posts'])->name('type');
            });

        });

        /**
         * Промокоды
         */
        Route::as('promocodes')->prefix('/promocodes')->middleware('permissions:' . Permissions::PROMOCODES)->group(function(){

            Route::get('/', [ViewsController::class, 'promocodes']);

            Route::as('.')->group(function() {

                Route::get('/create', [ViewsController::class, 'promocodesCreate'])->name('create');
                Route::get('/edit/{promocode}', [ViewsController::class, 'promocodesEdit'])->name('edit');

            });

        });

        /**
         * Промокоды
         */
        Route::as('mailing')->prefix('/mailing-list')->middleware('permissions:' . Permissions::MAILING)->group(function(){

            Route::get('/', [ViewsController::class, 'mailing']);

            Route::as('.')->group(function() {

                Route::get('/create', [ViewsController::class, 'mailingCreate'])->name('create');

            });

        });

        /**
         * Платежи
         */
        Route::as('payments')->prefix('/payments')->middleware('permissions:' . Permissions::PAYMENTS)->group(function(){
            Route::get('/', [ViewsController::class, 'payments']);
        });

        /**
         * Текста
         */
        Route::as('texts')->prefix('/texts')->middleware('permissions:' . Permissions::TEXTS)->group(function(){
            Route::get('/', [ViewsController::class, 'texts']);
        });

        /**
         * Переменные
         */
        Route::as('options')->prefix('/options')->middleware('permissions:' . Permissions::OPTIONS)->group(function(){
            Route::get('/', [ViewsController::class, 'options']);
        });


        /**
         * Статистика
         */
        Route::as('statistic')->prefix('/statistic')->middleware('permissions:' . Permissions::STATISTIC)->group(function(){
            Route::get('/', [ViewsController::class, 'statistic']);
        });

        Route::any('/logout', [AuthController::class, 'logout'])->name('logout');

    });
});

