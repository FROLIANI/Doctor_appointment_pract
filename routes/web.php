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
Route::get('/all_doctors',[AdminController::class,'show_doctors'])->name('all_doctors');
Route::get('/all_patients',[AdminController::class,'show_patients'])->name('all_patients');

Route::get('/view_doctor/{doctor}',[AdminController::class,'show'])->name('view_doctor');
Route::get('/edit_doctor/{doctor}',[AdminController::class,'edit'])->name('edit_doctor');
Route::put('/update_doctor/{doctor}',[AdminController::class,'update'])->name('admin.doctor.update');
Route::delete('/delete_doctor/{doctor}',[AdminController::class,'destroy'])->name('admin.doctor.destroy');
Route::get('/view_patient/{user}',[AdminController::class,'view_patient'])->name('view_patient');
Route::delete('/delete_patient/{user}',[AdminController::class,'destroy_patient'])->name('admin.patient.destroy_patient');

//For Doctor
Route::get('/doctor_dashbord',[DoctorController::class,'index'])->name('doctor_dashbord');
Route::post('/doctor/appointments/{appointment}/approve', [DoctorController::class, 'approve'])
    ->name('doctor.appointment.approve');

Route::post('/doctor/appointments/{appointment}/cancel', [DoctorController::class, 'cancel'])
    ->name('doctor.appointment.cancel');



//For Patient
Route::get('/patient_dashbord',[PatientController::class,'index'])->name('patient_dashbord');
Route::get('/make_appointment/{doctor}',[PatientController::class,'create'])->name('make_appointment');
Route::post('/make_appointment/{doctor}',[PatientController::class,'store'])->name('patient.store.appointment');


});


