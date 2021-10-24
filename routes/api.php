<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login'])->name('auth.login');
Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::middleware('auth:sanctum')->delete('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

Route::group(['prefix' => 'coingecko'], static function (): void {
    Route::get('ping', [\App\Http\Controllers\Api\CoinGecko\PingController::class, 'ping']);

    Route::group(['prefix' => 'coins'], static function (): void {
        Route::get('list', [\App\Http\Controllers\Api\CoinGecko\CoinsController::class, 'list']);
        Route::get('markets', [\App\Http\Controllers\Api\CoinGecko\CoinsController::class, 'markets']);
        Route::get('{id}', [\App\Http\Controllers\Api\CoinGecko\CoinsController::class, 'show']);

        Route::group(['prefix' => 'categories'], static function (): void {
            Route::get('list', [\App\Http\Controllers\Api\CoinGecko\CategoriesController::class, 'list']);
            Route::get('/', [\App\Http\Controllers\Api\CoinGecko\CategoriesController::class, 'listMarket']);
        });
    });
});
