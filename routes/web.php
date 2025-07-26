<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\PostController as UserPostController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\UserController as AdminUserContoller;
use App\Http\Controllers\Post\CommentController;
use App\Http\Controllers\Post\LikeController;
use App\Http\Controllers\New\NewController;

Route::get('/', [NewController::class, 'news'])->name('news');

Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {
    //Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register.post');

    //Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');

    //Forgot Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('auth.forgot_password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot_password.post');

    //Reset Password
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset_password.post');
});

Route::group(['middleware' => ['auth', 'check.user.status', 'role:user']], function () {
    //Post
    Route::delete('/post/delete-all', [UserPostController::class, 'deleteAll'])->name('post.delete_all');
    Route::get('/post/data', [UserPostController::class, 'data'])->name('post.data');
    Route::resource('post', UserPostController::class);
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'check.user.status', 'role:admin']], function () {
    //Manage Post
    Route::delete('/post/delete-all', [AdminPostController::class, 'adminDeleteAll'])->name('admin.post.delete_all');
    Route::get('/post/data', [AdminPostController::class, 'data'])->name('admin.post.data');
    Route::resource('/post', AdminPostController::class)->names('admin.post');

    //Manage User
    Route::get('/user/data', [AdminUserContoller::class, 'data'])->name('admin.user.data');
    Route::put('/user/{user}/toggle-lock', [AdminUserContoller::class, 'statusUser'])->name('admin.user.toggle_lock');
    Route::resource('/user', AdminUserContoller::class)->names('admin.user');
});

Route::middleware(['auth', 'check.user.status'])->group(function () {
    // Comment
    Route::post('/news/{post}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
    Route::get('/news/{post}/comments', [CommentController::class, 'dataComment'])->name('comment.data_comment');

    // Like
    Route::post('/news/{post}/like', [LikeController::class, 'store'])->name('like.store');
    Route::delete('/news/{post}/unlike', [LikeController::class, 'destroy'])->name('like.destroy');

    //Profile
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.show');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
});

//News
Route::get('/news', [NewController::class, 'news'])->name('news');
Route::get('/news/{post:slug}', [NewController::class, 'newsDetail'])->name('news.detail');

//Auth
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/auth/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('auth.reset_password.show');
