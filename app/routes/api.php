<?php

use Illuminate\Http\Request;

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

Route::post('/version', 'VersionController@control');

Route::prefix('/user')->group(function () {
    Route::post('login', 'UserController@login')->middleware('guest.api');
    Route::middleware('auth.api')->group(function () {
        Route::get('logout', 'UserController@logout');
    });
});
