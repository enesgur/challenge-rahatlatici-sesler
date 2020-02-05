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

Route::middleware('auth.api')->group(function () {
    Route::prefix('/category')->group(function () {
        Route::get('list', 'CategoryController@list');
        Route::get('songs/{id}', 'CategoryController@songs')->where('id', '[0-9]+');
    });

    Route::prefix('/favorites')->group(function () {
        Route::get('songs', 'FavoriteController@songs');
        Route::post('add', 'FavoriteController@add');
        Route::delete('remove/{id}', 'FavoriteController@remove')->where('id', '[0-9]+');
    });
});
