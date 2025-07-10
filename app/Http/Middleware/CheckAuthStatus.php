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
        $user = Auth::user();
        switch ($user->status) {
            case AuthStatus::PENDING:
                Auth::logout();
                return to_route('auth.login')
                    ->with('error', 'Tài khoản của bạn đang chờ xác nhận.');

            case AuthStatus::REJECTED:
                Auth::logout();
                return to_route('auth.login')
                    ->with('error', 'Tài khoản của bạn đã bị từ chối');

            case AuthStatus::LOCKED:
                Auth::logout();
                return to_route('auth.login')
                    ->with('error', 'Tài khoản của bạn đã bị khóa');

            case AuthStatus::APPROVED:
                return $next($request);

            default:
                return to_route('auth.login')->with('error', 'Tài khoản của bạn không hợp lệ');
        }
    }
}
