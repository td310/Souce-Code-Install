<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

//Test Accessors
Route::get('user/{userId}', [AuthController::class, 'showUserName']);

Route::get('/', function () {
    return redirect()->route('auth.login');
});

Route::group(['prefix' => 'auth'], function () {
    // Form đăng ký
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register.post');

    //Form đăng nhập
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
});

Route::middleware(['auth', 'check.user.status'])->group(function () {
    Route::get('/post', [PostController::class, 'index'])->name('post.index');
});

