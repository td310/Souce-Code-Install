<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;

//Demo XSS
Route::get('/comments', [CommentController::class, 'index']);
Route::post('/comments', [CommentController::class, 'store']);

#---------------------------------#
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
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('auth.forgot_password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot_password.post');

    //Reset mật khẩu mới
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset_password.post');
});

Route::middleware(['check.user.status'])->group(function () {
    Route::delete('/post/delete-all', [PostController::class, 'deleteAll'])->name('post.delete_all');
    Route::resource('post', PostController::class);

    //Cập nhật hồ sơ
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.show');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/auth/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('auth.reset_password.show');
