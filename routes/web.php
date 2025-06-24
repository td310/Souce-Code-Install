<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Models\User;


//Test Accessors
Route::get('user/{userId}', [AuthController::class, 'showUserName']);

//test status
Route::get('/test-status', function () {
    $user = User::find(3);
    if ($user) {
        return [
            'status_value' => $user->status->value,
            'status_label_accessor' => $user->status_label,
        ];
    }
});

//test append
Route::get('/test-appends', function () {
    $users = User::all();
    return response()->json($users);
});

Route::get('/home', [HomeController::class, 'index']);


/* ------------------------------------------------------ */
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
});


Route::middleware(['auth', 'check.user.status'])->group(function () {
    Route::get('/post', [PostController::class, 'index'])->name('post.index');
});
