<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;


// Главная страница
Route::get('/', [EventController::class, 'index'])->name('home');

// Пользовательские маршруты
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::put('/user', [UserController::class, 'update'])->name('user.update');

    Route::post('/events/{event}/register', [EventController::class, 'register'])->name('events.register');
    Route::post('/events/{event}/cancel', [EventController::class, 'cancel'])->name('events.cancel');
});

// Админские маршруты
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::put('/admin', [AdminController::class, 'update'])->name('admin.update');

    // Управление мероприятиями
    Route::get('/admin/events', [AdminController::class, 'events'])->name('admin.events');
    Route::put('/admin/events/{id}/toggle-status',
        [EventController::class, 'toggleEventStatus'])->name('events.toggleEventStatus');
    Route::delete('/admin/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

    // Управление категориями
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::put('/admin/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Управление пользователями
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::put('admin/users/{user}/toggle',
        [UserController::class, 'toggleUserStatus'])->name('users.toggleUserStatus');
    Route::delete('admin/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Маршруты для верификации электронной почты
Route::get('/email/verify', [VerificationController::class, 'notice'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware([
    'auth', 'signed'
])->name('verification.verify');
Route::get('/email/verification-notification', [VerificationController::class, 'send'])->middleware([
    'auth', 'throttle:6,1'
])->name('verification.send');

// Маршруты аутентификации
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
