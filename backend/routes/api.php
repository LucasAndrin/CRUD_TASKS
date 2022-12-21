<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserAdminController;
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
});
