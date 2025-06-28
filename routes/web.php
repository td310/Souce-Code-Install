<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'index']);

Route::get('/', function () {
    return redirect()->route('auth.login');
});

Route::group(['prefix' => 'auth', 'middleware' => 'check.login'], function () {
    // Form đăng ký
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register.post');

    //Form đăng nhập
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');

    //Quên mật khẩu
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('auth.forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot-password.post');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/auth/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('auth.reset-password.show');

Route::middleware(['check.user.status'])->group(function () {
    Route::get('/post', [PostController::class, 'index'])->name('post.index');
});
