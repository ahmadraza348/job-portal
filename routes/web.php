<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\JobController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs');
Route::get('/hash', function () {
    return Hash::make('admin@gmail.com');
});

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
        Route::get('/my-job', [AccountController::class, 'myJobs'])->name('account.myJobs');
        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::put('/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::post('/update-profile-pic', [AccountController::class, 'updateProfilePic'])->name('account.updateProfilePic');
        Route::get('/create-job', [AccountController::class, 'createJob'])->name('account.createJob');
        Route::post('/save-job', [AccountController::class, 'saveJob'])->name('account.saveJob');
        Route::get('/edit-job/{jobid}', [AccountController::class, 'editJob'])->name('account.editJob');
        Route::post('/update-job/{jobid}', [AccountController::class, 'updateJob'])->name('account.updateJob');
        Route::post('/delete-job', [AccountController::class, 'deleteJob'])->name('account.deleteJob');
    });

});
