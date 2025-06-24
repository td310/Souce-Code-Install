<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;


class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showUserName($userId)
    {
        return $this->authService->getUserName($userId);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        return $result
            ? to_route('auth.login')->with('success', 'Đăng ký tài khoản thành công')
            : to_route('auth.login')->with('error', 'Đăng ký tài khoản thất bại');
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->loginUser($request->validated());

        return $result
            ? to_route('post.index')->with('success', 'Đăng nhập thành công')
            : to_route('auth.login')->with('error', 'Đăng nhập thất bại');
    }
}
