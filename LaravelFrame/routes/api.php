<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the 'api' middleware group. Enjoy building your API!
|
*/

// Authentication
Route::post('login', 'Auth\AuthController@authenticateByPassport');
Route::get('logout', 'Auth\AuthController@logout');

// Post API
Route::post('/post/create', 'PostController@createPosts');
Route::get('/post/list', 'PostController@index');
Route::get('/post/{id}', 'PostController@show');
Route::put('/post/{id}', 'PostController@update');
Route::delete('/post/{id}', 'PostController@destroy');

// User API
Route::post('/user/create','User\UserController@register');
Route::get('/user/list', 'User\UserController@getUserList');
Route::get('/user/{id}', 'User\UserController@show');
Route::delete('/user/{id}', 'User\UserController@destroy');
Route::put('user/{id}','User\UserController@update');

