<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//Auth
Route::post('register-user', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


//user routes
Route::get('users', [UserController::class, 'index'])->middleware(['auth:sanctum', 'user.check']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::put('users/{user}', [UserController::class, 'update'])->middleware('auth:sanctum');
Route::delete('users/{user}', [UserController::class, 'destroy'])->middleware('auth:sanctum');


Route::get('posts', [PostController::class, 'index']);
Route::post('posts', [PostController::class, 'store']);
