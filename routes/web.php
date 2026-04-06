<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProgressController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('home'))->name('home');

// auth gawe guest tok
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// klo authenticated
Route::middleware('auth')->group(function () {
    Route::post('/logout', LogoutController::class)->name('logout');

    Route::get('/dashboard', function () {
        return match (Auth::user()->role) { //arahkn sesuai role
            'owner' => redirect()->route('owner.dashboard'),
            'receptionist' => redirect()->route('receptionist.dashboard'),
            default => view('dashboard.index'),
        };
    })->name('dashboard');
    
    Route::middleware('role:owner')->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', fn() => view('dashboard.owner'))->name('dashboard');
    });

    Route::middleware('role:receptionist')->prefix('receptionist')->name('receptionist.')->group(function () {
        Route::get('/dashboard', fn() => view('dashboard.receptionist'))->name('dashboard');
    });

    Route::middleware('role:member')->group(function () {
        Route::get('/dashboard/progress', [ProgressController::class, 'index'])->name('progress.index');
        Route::post('/dashboard/progress', [ProgressController::class, 'store'])->name('progress.store');
        Route::delete('/dashboard/progress/{progressLog}', [ProgressController::class, 'destroy'])->name('progress.destroy');
    });

});
