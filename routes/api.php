<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Requests\Post\FilterPostRequest;
use App\Http\Requests\User\FilterUserRequest;
use App\Models\Post;
use App\Models\User;
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
Route::get('users', [UserController::class, 'index'])->middleware(['auth:sanctum', 'can.view.all.users']);
// Route::get('users', [UserController::class, 'index']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::put('users/{user}', [UserController::class, 'update'])->middleware('auth:sanctum');
Route::delete('users/{user}', [UserController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('users-filter', function (FilterUserRequest $request) {
    return User::query()->filter()->get(); //in the api send it as param: filter[attrbiute]        value=.....
});
///////////


// Post routes \\\\\\
Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{post}', [PostController::class, 'show']);
Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('posts', [PostController::class, 'store']);
    Route::put('posts/{post}', [PostController::class, 'update']);
    Route::delete('posts/{post}', [PostController::class, 'destroy']);
});
Route::get('posts-filter', function (FilterPostRequest $request) {
    return Post::query()->filter()->get();
});
//////////////////////



// Comment routes \\\\\\
Route::get('comments', [CommentController::class, 'index']);
Route::get('comments/{comment}', [CommentController::class, 'show']);

Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('comments', [CommentController::class, 'store']);
    Route::put('comments/{comment}', [CommentController::class, 'update']);
    Route::delete('comments/{comment}', [CommentController::class, 'destroy']);
});
//////////////////////
