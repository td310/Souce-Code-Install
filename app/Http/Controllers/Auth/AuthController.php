<?php

namespace App\Http\Controllers\Auth;

use App\Services\Auth\AuthService;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ForgotPassRequest;
use App\Http\Requests\Auth\ResetPassRequest;
use App\Http\Requests\Auth\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Enums\AuthRole;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot_pass');
    }

    public function showResetPassword($token)
    {
        return view('auth.get_pass', ['token' => $token]);
    }

    public function showProfile()
    { 
        $user = Auth::user();
        return view('post.profile', compact('user'));
    }

    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request->validated())
            ? to_route('auth.login')->with('success', 'Đăng ký tài khoản thành công')
            : to_route('auth.login')->with('error', 'Đăng ký tài khoản thất bại');
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authService->loginUser($request->validated());
    
        if (!$user) {
            return to_route('auth.login')->with('error', 'Đăng nhập thất bại');
        }
    
        return match ($user->role) {
            AuthRole::ADMIN => to_route('admin.post.index')->with('success', 'Đăng nhập thành công'),
            AuthRole::USER => to_route('post.index')->with('success', 'Đăng nhập thành công'),
            default => to_route('auth.login')->with('error', 'Vai trò không hợp lệ')
        };
    }
    
    public function logout()
    {
        Auth::logout();
        return to_route('news')->with('success', 'Đăng xuất thành công');
    }

    public function forgotPassword(ForgotPassRequest $request)
    {
        return $this->authService->forgotPassword($request->email)
            ? to_route('auth.forgot_password')->with('success', 'Vui lòng kiểm tra email để đặt lại mật khẩu.')
            : to_route('auth.forgot_password')->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
    }

    public function resetPassword(ResetPassRequest $request)
    {
        return $this->authService->resetPassword($request->token, $request->password)
            ? to_route('auth.login')->with('success', 'Đặt lại mật khẩu thành công.')
            : to_route('auth.reset_password.show')->with('error', 'Đã có lỗi xảy ra, vui lòng thử lại.');
    }

    public function updateProfile(ProfileRequest $request)
    {
        return $this->authService->updateProfile($request->validated())
            ? to_route('profile.show')->with('success', 'Cập nhật hồ sơ thành công')
            : to_route('profile.show')->with('error', 'Cập nhật hồ sơ thất bại');
    }
}
