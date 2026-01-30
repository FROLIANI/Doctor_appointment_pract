<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/show', [AuthController::class, 'show']);
    Route::put('/edit', [AuthController::class, 'edit']);
    Route::patch('/delete', [AuthController::class, 'edit']);
    Route::delete('/delete', [AuthController::class, 'destroy']);
    Route::get('/users',          [UserController::class, 'index']);
    Route::get('/users/{user}',   [UserController::class, 'showUser']);
    Route::put('/users/{user}',   [UserController::class, 'updateUser']);
    Route::patch('/users/{user}', [UserController::class, 'updateUser']);
    Route::delete('/users/{user}',[UserController::class, 'destroyUser']);
    Route::post('/logout',[AuthController::class, 'logout']);
});
