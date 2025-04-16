<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('register-user', [AuthController::class, 'register']);

Route::get('users', [UserController::class, 'index']);



Route::get('posts', [PostController::class, 'index']);
Route::post('posts', [PostController::class, 'store']);
