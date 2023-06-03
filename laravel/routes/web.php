<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


Route::get('/users/login', [UserController::class,'login'])->name('users.login');
Route::post('/users/loginpost', [UserController::class,'loginpost'])->name('users.login.post');

Route::get('/boards/list', [BoardController::class,'list'])->name('boards.list');
Route::get('/boards/write', [BoardController::class,'write'])->name('boards.write');
Route::post('/boards/writepost', [BoardController::class,'writepost'])->name('boards.write.post');
