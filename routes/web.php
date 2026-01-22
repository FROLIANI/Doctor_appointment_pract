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



Route::middleware(['auth'])->group(function(){

//For admin
Route::get('/admin_dashbord',[AdminController::class,'index'])->name('admin_dashbord');
Route::get('/add_doctor',[AdminController::class,'create'])->name('add_doctor');
Route::post('/add_doctor',[AdminController::class,'store'])->name('admin.doctor.store');

//For Doctor
Route::get('/doctor_dashbord',[DoctorController::class,'index'])->name('doctor_dashbord');


//For Patient
Route::get('/patient_dashbord',[PatientController::class,'index'])->name('patient_dashbord');
Route::get('/make_appointment/{doctor}',[PatientController::class,'create'])->name('make_appointment');
Route::post('/make_appointment/{doctor}',[PatientController::class,'store'])->name('patient.store.appointment');


});


