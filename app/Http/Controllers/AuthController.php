<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotPassRequest;
use App\Http\Requests\ResetPassRequest;
use Illuminate\Support\Facades\Auth;

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
        return view('auth.forgotPass');
    }

    public function showResetPassword($token)
    {
        return view('auth.getPass', ['token' => $token]);
    }

    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request)
            ? to_route('auth.login')->with('success', 'Đăng ký tài khoản thành công')
            : to_route('auth.login')->with('error', 'Đăng ký tài khoản thất bại');
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->loginUser($request->validated())
            ? to_route('post.index')->with('success', 'Đăng nhập thành công')
            : to_route('auth.login')->with('error', 'Đăng nhập thất bại');
    }

    public function logout()
    {
        Auth::logout();
        return to_route('auth.login')->with('success', 'Đăng xuất thành công');
    }

    public function forgotPassword(ForgotPassRequest $request)
    {
        return $this->authService->forgotPassword($request->email)
            ? back()->with('success', 'Vui lòng kiểm tra email để đặt lại mật khẩu.')
            : back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
    }

    public function resetPassword(ResetPassRequest $request)
    {
        return $this->authService->resetPassword($request->token, $request->password)
            ? to_route('auth.login')->with('success', 'Đặt lại mật khẩu thành công.')
            : back()->with('error', 'Đã có lỗi xảy ra, vui lòng thử lại.');
    }
}
