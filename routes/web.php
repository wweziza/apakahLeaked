<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NikCheckController;
use App\Http\Controllers\Auth\LoginController; 
use App\Http\Controllers\Auth\RegisterController; 
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataManagementController;
use Illuminate\Support\Facades\Auth;    

Route::post('/check-nik', [NikCheckController::class, 'check']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.summary');
    })->name('dashboard');

    Route::get('/data-management', function () {
        return view('dashboard.dataManagement');
    })->name('data-management');
    
    Route::prefix('data')->group(function () {
        Route::get('/stats', [DataManagementController::class, 'getStats']); // Move this up
        Route::get('/list', [DataManagementController::class, 'list']);
        Route::get('/search', [DataManagementController::class, 'search']);
        Route::post('/', [DataManagementController::class, 'store']);
        Route::get('/{id}', [DataManagementController::class, 'show']);
        Route::put('/{id}', [DataManagementController::class, 'update']);
        Route::delete('/{id}', [DataManagementController::class, 'destroy']);
    });

});