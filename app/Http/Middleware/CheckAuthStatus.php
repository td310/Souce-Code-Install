<?php

namespace App\Http\Middleware;

use App\Enums\AuthStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            switch ($user->status) {
                case AuthStatus::PENDING:
                    Auth::logout();
                    return redirect()->route('auth.login')
                        ->with('error', 'Tài khoản của bạn đang chờ xác nhận.');

                case AuthStatus::REJECTED:
                    Auth::logout();
                    return redirect()->route('auth.login')
                        ->with('error', 'Tài khoản của bạn đã bị từ chối');

                case AuthStatus::LOCKED:
                    Auth::logout();
                    return redirect()->route('auth.login')
                        ->with('error', 'Tài khoản của bạn đã bị khóa');

                case AuthStatus::APPROVED:
                    return $next($request);
            }
        }

        Auth::logout();
        return redirect()->route('auth.login')
            ->with('error', 'Trạng thái tài khoản không hợp lệ');
    }
}
