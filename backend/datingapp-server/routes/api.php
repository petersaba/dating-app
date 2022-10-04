<?php

use App\Http\Controllers\ActionsController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('user/{id?}', [AuthController::class, 'addOrEditUser']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::get('userinfo/{user_id}', [AuthController::class, 'getUserInfo']);
Route::post('favorite', [ActionsController::class, 'addOrRemoveFavorite']);
Route::post('block', [ActionsController::class, 'addOrRemoveBlock']);


Route::group(['middleware' => 'auth:api'], function(){
    Route::post('test', [AuthController::class, 'test']);
});


//     Route::post('logout', [AuthController::class, 'logout']);
//     Route::post('refresh', [AuthController::class, 'refresh']);
//     Route::post('me', [AuthController::class, 'me']);