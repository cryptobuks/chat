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
Route::get('/users', 'Api\UserController@index');
Route::get('/users/search', 'Api\UserController@search');
Route::put('/users/invite', 'Api\UserController@invite');
