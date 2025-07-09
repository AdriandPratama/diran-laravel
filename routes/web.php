<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\BatteryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\MappingController;
use App\Http\Controllers\DataLogController;

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

// BATTERY CRUD
Route::get('/battery', [BatteryController::class, 'index'])->name('battery');
Route::post('/battery', [BatteryController::class, 'store'])->name('battery.store');
Route::put('/battery/update/{id}', [BatteryController::class, 'update'])->name('battery.update');
Route::delete('/battery/{id}', [BatteryController::class, 'destroy'])->name('battery.destroy');

// PROFILE ROUTE
Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');
Route::post('/profile/update-picture', [ProfileController::class, 'updateProfilePicture'])->name('profile.update_picture')->middleware('auth');
Route::delete('/profile/delete-picture', [ProfileController::class, 'deleteProfilePicture'])->name('profile.deletePicture');

// SETTING ROUTES (untuk admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting/update-role/{id}', [SettingController::class, 'updateRole'])->name('setting.updateRole');
});

// SETTING IP RFID ROUTES
Route::get('/mapping', [MappingController::class, 'index'])->name('mapping.index');

// RFID Mapping
Route::post('/mapping/rfid', [MappingController::class, 'storeRfid'])->name('mapping.rfid');
Route::post('/mapping/ip', [MappingController::class, 'storeIp'])->name('mapping.ip');

// Edit & Delete
Route::get('/mapping/rfid/{id}/edit', [MappingController::class, 'editRfid'])->name('mapping.rfid.edit');
Route::get('/mapping/ip/{id}/edit', [MappingController::class, 'editIp'])->name('mapping.ip.edit');

Route::post('/mapping/rfid/{id}/update', [MappingController::class, 'updateRfid'])->name('mapping.rfid.update');
Route::post('/mapping/ip/{id}/update', [MappingController::class, 'updateIp'])->name('mapping.ip.update');

Route::delete('/mapping/rfid/{id}', [MappingController::class, 'destroyRfid'])->name('mapping.rfid.destroy');
Route::delete('/mapping/ip/{id}', [MappingController::class, 'destroyIp'])->name('mapping.ip.destroy');




// FORGOT & RESET PASSWORD
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// DATALOG - dengan parameter tambahan "source" untuk identifikasi tabel
Route::get('/datalog', [DataLogController::class, 'index'])->name('datalog');
Route::post('/datalog', [DataLogController::class, 'store'])->name('datalog.store');
Route::put('/datalog/{id}/{source}', [DataLogController::class, 'update'])->name('datalog.update');
Route::delete('/datalog/{id}/{source}', [DataLogController::class, 'destroy'])->name('datalog.destroy');

