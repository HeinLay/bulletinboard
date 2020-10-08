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

Route::post('/login', 'Auth\AuthController@authenticateByPassport');
Route::post('/user/create','User\UserController@register');
// Route::get('user/list', 'User\UserController@getUserList');
Route::get('/user/list', 'User\UserController@getUserList');
Route::Post('/post/create', [PostController::class, 'createPosts']);
Route::Get('/post/list',[PostController::class,'index']);
