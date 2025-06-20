<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\AuthRequest;
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

    public function register(AuthRequest $request)
    {
        $result = $this->authService->register($request->validated());
        if ($result) {
            return redirect()->route('auth.login')
                ->with('success', 'Đăng ký tài khoản thành công');
        }
        return redirect()->route('auth.login')
            ->with('error', 'Đăng ký tài khoản thất bại');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $result = $this->authService->loginUser($credentials);

        if ($result) {
            return redirect()->route('post.index')
                ->with('success', 'Đăng nhập thành công');
        }
        return redirect()->route('auth.login')
            ->with('error', 'Đăng nhập thất bại');
    }
}
