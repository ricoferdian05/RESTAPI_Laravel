<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// GROUP ROUTE WITH MIDDLEWARE
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/getDataToken', [AuthenticationController::class, 'getDataToken']);
    Route::get('/logout', [AuthenticationController::class, 'logout']);

    Route::post('/posts', [PostController::class, 'store']);

    Route::patch('/posts/{id}', [PostController::class, 'update'])->middleware(['ensure.token']);

    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->middleware(['ensure.token']);
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::get('/posts2/{id}', [PostController::class, 'show2']);

Route::post('/login', [AuthenticationController::class, 'login']);
