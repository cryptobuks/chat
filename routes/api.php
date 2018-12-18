<?php

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

Route::post('/users', 'Api\UserController@login');
Route::middleware('auth:api')->prefix('users')->group(function () {
    Route::get('/', 'Api\UserController@index');
    Route::get('/search', 'Api\UserController@search');
    Route::put('/invite', 'Api\UserController@invite');
});
