<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest-only authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});

// Authenticated application routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::view('/', 'pages.dashboard')->name('dashboard');
    Route::view('/transactions', 'pages.transactions.index')->name('transactions.index');
    Route::view('/wallets', 'pages.wallets.index')->name('wallets.index');
    Route::view('/categories', 'pages.categories.index')->name('categories.index');
    Route::view('/reports', 'pages.reports.index')->name('reports.index');
    Route::view('/settings', 'pages.settings.index')->name('settings.index');
});
