<?php

use App\Http\Controllers\ActionsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GetUsersController;
use Illuminate\Support\Facades\Route;


Route::post('user/{id?}', [AuthController::class, 'addOrEditUser']);
Route::post('login', [AuthController::class, 'login'])->name('login');



Route::group(['middleware' => 'auth:api'], function(){
    Route::get('userinfo/{user_id}', [AuthController::class, 'getUserInfo']);
    Route::get('favorites/{user_id}', [GetUsersController::class, 'getFavorites']);
    Route::get('homepage/{user_id}', [GetUsersController::class, 'getHomepageUsers']);
    Route::post('favorite', [ActionsController::class, 'addOrRemoveFavorite']);
    Route::post('block', [ActionsController::class, 'addOrRemoveBlock']);
    Route::post('message', [ActionsController::class, 'newMessage']);
});


//     Route::post('logout', [AuthController::class, 'logout']);
//     Route::post('refresh', [AuthController::class, 'refresh']);
//     Route::post('me', [AuthController::class, 'me']);