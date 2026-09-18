<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminStatisticsController;
use App\Http\Controllers\Admin\RegionAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectSubmissionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('home');

Route::middleware('auth')->group(function (): void {
    Route::get('/panel', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/chiqish', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->group(function (): void {
        Route::get('/', AdminDashboardController::class)->name('dashboard');
        Route::get('/statistics', [AdminStatisticsController::class, 'index'])->name('statistics.index');
        Route::get('/statistics/export/{type}', [AdminStatisticsController::class, 'export'])
            ->where('type', 'users|submissions')
            ->middleware('throttle:30,1')
            ->name('statistics.export');
        Route::post('/statistics/users/parol', [AdminStatisticsController::class, 'updateUserPassword'])
            ->middleware('throttle:30,1')
            ->name('statistics.users.password');
        Route::get('/projects', [AdminProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{projectSubmission}', [AdminProjectController::class, 'show'])->name('projects.show');
        Route::get('/projects/{projectSubmission}/fayl', [AdminProjectController::class, 'download'])
            ->middleware('throttle:60,1')
            ->name('projects.download');
        Route::post('/projects/{projectSubmission}/qabul', [AdminProjectController::class, 'accept'])
            ->middleware('throttle:30,1')
            ->name('projects.accept');
        Route::post('/projects/{projectSubmission}/rad-etish', [AdminProjectController::class, 'reject'])
            ->middleware('throttle:30,1')
            ->name('projects.reject');

        Route::middleware('super_admin')->group(function (): void {
            Route::resource('region-admins', RegionAdminController::class)
                ->except(['show'])
                ->middleware('throttle:60,1');
        });
    });

    Route::get('/ariza-topshirish', [ProjectSubmissionController::class, 'create'])->name('project.submit.form');
    Route::post('/ariza-topshirish', [ProjectSubmissionController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('project.submit');

    Route::get('/ariza/{projectSubmission}/materiallar', [ProjectSubmissionController::class, 'download'])
        ->middleware('throttle:30,1')
        ->name('project.submission.download');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
    Route::get('/register/verify', [AuthController::class, 'showRegisterVerifyForm'])->name('register.verify');
    Route::post('/register/verify', [AuthController::class, 'registerVerify'])->middleware('throttle:10,1');
    Route::post('/register/verify/resend', [AuthController::class, 'registerResendOtp'])->name('register.verify.resend')->middleware('throttle:5,1');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
});
