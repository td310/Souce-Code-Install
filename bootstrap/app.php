<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckAuthStatus;
use App\Enums\AuthRole;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\RoleUser;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'check.user.status' => CheckAuthStatus::class,
            'role' => RoleUser::class
        ]);
        $middleware->redirectUsersTo(function () {
            return Auth::user()->role === AuthRole::ADMIN ? '/admin/post' : '/post';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
