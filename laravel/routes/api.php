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
Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::any('/', function () {
        return [
            'app' => config('app.name')
        ];
    });

    Route::post('/login', [\App\Http\Controllers\SecurityController::class, 'login']);
});

Route::group([
    'middleware' => 'auth:sanctum',
], function ($router) {
    Route::post('/logout', [\App\Http\Controllers\SecurityController::class, 'logout']);
    Route::get('/me', [\App\Http\Controllers\SecurityController::class, 'me']);
    Route::get('/logout', [\App\Http\Controllers\SecurityController::class, 'logout']);

    /** USERS **/
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
    Route::post('/users', [\App\Http\Controllers\UserController::class, 'store']);
    Route::get('/users/{id?}', [\App\Http\Controllers\UserController::class, 'show']);
    Route::patch('/users/{id}', [\App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/users/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);
    /** END USERS **/

    /** ADDRESS **/
    Route::get('/users/{user}/address', [\App\Http\Controllers\User\AddressController::class, 'index']);

    /** END ADDRESS **/

    // create a subdomain route here
});
