<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/register',[AuthController::class,'create'])->name('register');
Route::post('/register',[AuthController::class, 'store'])->name('register.post');

Route::get('/login',[AuthController::class,'index'])->name('login');
Route::post('/login',[AuthController::class,'login'])->name('login.post');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');

Route::get('/admin_dashbord',[AdminController::class,'index'])->name('admin_dashbord');
Route::get('/doctor_dashbord',[DoctorController::class,'index'])->name('doctor_dashbord');
Route::get('/patient_dashbord',[PatientController::class,'index'])->name('patient_dashbord');
