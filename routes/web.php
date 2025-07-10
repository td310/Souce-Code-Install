<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminUserController;

//Demo XSS
Route::get('/comments', [CommentController::class, 'index']);
Route::post('/comments', [CommentController::class, 'store']);

#---------------------------------#
Route::get('/home', [HomeController::class, 'index']);

Route::get('/', function () {
    return redirect()->route('auth.login');
});

Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {
    //Form đăng ký
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

Route::group(['middleware' => ['auth', 'check.user.status', 'role:user']], function () {
    //Bài viết
    Route::delete('/post/delete-all', [PostController::class, 'deleteAll']);
    Route::get('/post/data', [PostController::class, 'data']);
    Route::resource('post', PostController::class);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'check.user.status', 'role:admin']], function () {
    //Quản lý bài viết
    Route::delete('/post/delete-all', [AdminPostController::class, 'adminDeleteAll']);
    Route::get('/post/data', [AdminPostController::class, 'data']);
    Route::resource('/post', AdminPostController::class)->names('admin.post');

    //Quản lý người dùng
    Route::get('/user/data', [AdminUserController::class, 'data']);
    Route::resource('/user', AdminUserController::class)->names('admin.user');
});

Route::middleware(['auth', 'check.user.status'])->group(function () {
    //Tin tức
    Route::get('/news', [PostController::class, 'news'])->name('post.news');
    Route::get('/news/{post:slug}', [PostController::class, 'newsDetail'])->name('post.news_detail');

    //Cập nhật hồ sơ
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.show');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/auth/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('auth.reset_password.show');
