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
Route::middleware('api')
    ->post('/login', [\App\Http\Controllers\SecurityController::class, 'login']);

Route::group([
    'middleware' => 'auth:sanctum',
], function ($router) {
    Route::post('/logout', [\App\Http\Controllers\SecurityController::class, 'logout']);
    Route::get('/me', [\App\Http\Controllers\SecurityController::class, 'me']);

    /** USERS **/
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index']);
    Route::get('/users/{id?}', [App\Http\Controllers\UserController::class, 'show']);

    /** END USERS **/

    // create a subdomain route here
});
