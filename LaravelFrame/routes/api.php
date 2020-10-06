<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostController;
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
// User routes
Route::Post('register',[LoginController::class, 'register']);
Route::Post('login',[LoginController::class, 'login']);
// Post routes
Route::Post('/post/create', [PostController::class, 'createPosts']);
