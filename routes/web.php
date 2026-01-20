<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/register',[AuthController::class,'create'])->name('create');
Route::post('/register',[AuthController::class, 'store'])->name('store.post');

Route::get('/login',[AuthController::class,'index'])->name('index');
