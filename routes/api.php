<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

Route::post('register' , [UserController::class , 'register']);
Route::post('login' , [UserController::class , 'login']);

Route::middleware('auth:api')->group( function (){
    Route::get('user',[UserController::class, 'login']);
    Route::post('save-post',[PostController::class ,'store']);
    Route::get('posts' ,[PostController::class, 'index']);
});
