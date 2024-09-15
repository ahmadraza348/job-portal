<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('account')->group(function () {
    
    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::get('/register', [AccountController::class, 'registration'])->name('account.registration');
        Route::get('/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('/account/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');
        Route::post('/process-register', [AccountController::class, 'process_registration'])->name('account.processRegistration');
    });
    
    // Authenticated Routes
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::put('/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::post('/update-profile-pic', [AccountController::class, 'updateProfilePic'])->name('account.updateProfilePic');
    });

});
