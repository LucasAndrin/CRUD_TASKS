<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\UserCoordinatorController;
use App\Http\Controllers\UserResponsibleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('auth', 'auth')->name('auth');
        Route::post('logout', 'logout')->name('logout');
    });

    Route::controller(UserAdminController::class)->prefix('admin')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('', 'index');
            Route::post('store', 'store');
            Route::put('update', 'update');
            Route::get('show', 'show');
            Route::delete('destroy', 'destroy');
        });
    });

    Route::controller(UserCoordinatorController::class)->prefix('coordinator')->group(function () {
        Route::get('responsibles', 'responsibles');
        Route::prefix('tasks')->group(function () {
            Route::get('', 'index');
            Route::post('store', 'store');
            Route::put('update', 'update');
            Route::get('show', 'show');
        });
    });

    Route::controller(UserResponsibleController::class)->prefix('responsible')->group(function () {
        Route::prefix('tasks')->group(function () {
            Route::get('', 'index');
            Route::prefix('mark-as')->group(function () {
                Route::post('progress', 'initiate');
                Route::put('stoped', 'update');
                Route::get('completed', 'show');
            });
        });
    });
});
