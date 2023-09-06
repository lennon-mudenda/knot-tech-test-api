<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\API\CardAPIController;
use App\Http\Controllers\API\MerchantAPIController;
use App\Http\Controllers\API\RegistrationAPIController;
use App\Http\Controllers\API\CardSwitchTaskAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('users')->as('users.')->group(function () {

    Route::controller(RegistrationAPIController::class)->group(
        static function (): void {

            Route::post('register', 'register')->name('register');

        }
    );

    Route::prefix('auth')->as('auth.')->controller(AuthAPIController::class)->group(
        static function (): void {

            Route::post('login', 'login')->name('login');

            Route::middleware('auth:sanctum')->group(static function (): void {
                Route::get('logout', 'logout')->name('logout');

                Route::get('refresh', 'refresh')->name('refresh');

                Route::get('user', 'user')->name('user');
            });

        }
    );

});


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('cards')
        ->controller(CardAPIController::class)
        ->group(function () {

        Route::get('', 'index')->name('index');

        Route::post('', 'store')->name('store');

    });


    Route::prefix('merchants')
        ->controller(MerchantAPIController::class)
        ->group(function () {

        Route::get('', 'index')->name('index');

    });

    Route::prefix('card-switch-tasks')
        ->as('card-switch-tasks')
        ->controller(CardSwitchTaskAPIController::class)
        ->group(function () {

        Route::get('', 'index')->name('index');

        Route::post('', 'store')->name('store');

        Route::match(['patch', 'put'], '{id}/markTaskFinished', 'markTaskFinished')->name('update.markTaskFinished');

        Route::match(['patch', 'put'], '{id}/markTaskFailed', 'markTaskFailed')->name('update.markTaskFailed');

    });
});

