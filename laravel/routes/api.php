<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users/{email}',[ApiUserController::class,'getuser']);
Route::post('/users',[ApiUserController::class,'postuser']);
Route::put('/users/{email}',[ApiUserController::class,'putuser']);
Route::delete('/users/{email}',[ApiUserController::class,'deleteuser']);