<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BatteryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// LOGIN & REGISTER
Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/log', [LoginController::class, 'login'])->name('login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/regist', [RegisterController::class, 'store'])->name('register.store');

// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');


Route::get('/rfid', function () {
    return view('dashboard.rfid');
})->name('rfid');

// LOCATION CRUD (pakai LocationController)
Route::get('/location', [LocationController::class, 'index'])->name('location');
Route::post('/location', [LocationController::class, 'store'])->name('location.store');
Route::put('/location/update/{id}', [LocationController::class, 'update'])->name('location.update');
Route::delete('/location/{id}', [LocationController::class, 'destroy'])->name('location.destroy');

//battery crud
Route::get('/battery', [BatteryController::class, 'index'])->name('battery');
Route::post('/battery', [BatteryController::class, 'store'])->name('battery.store');
Route::put('/battery/update/{id}', [BatteryController::class, 'update'])->name('battery.update');
Route::delete('/battery/{id}', [BatteryController::class, 'destroy'])->name('battery.destroy');
