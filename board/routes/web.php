<?php

/************************************
 *  프로젝트명 : laravel_board
 *  디렉토리   : routes
 *  파일명     : web.php
 *  이력       : v001 0530 JA.KIM new
 ************************************/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardsController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::resource('/boards', BoardsController::class);

Route::get('/users/login',[UserController::class,'login'])->name('users.login');
Route::post('/users/loginpost',[UserController::class,'loginpost'])->name('users.login.post');
Route::get('/users/sign',[UserController::class,'sign'])->name('users.sign');
Route::post('/users/signpost',[UserController::class,'signpost'])->name('users.sign.post');
Route::get('users/logout',[UserController::class,'logout'])->name('users.logout');
Route::get('users/withraw',[UserController::class,'withraw'])->name('users.withraw');
Route::get('/users/myinfo',[UserController::class,'myinfo'])->name('users.myinfo');
Route::put('users/myinfoput',[UserController::class,'myinfoput'])->name('users.myinfo.put');