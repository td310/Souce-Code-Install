<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendWelcomeEmailJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthService
{
    public function getUserName($userId): string
    {
        $user = User::find($userId);
        return "Tên admin: {$user->name}";
    }

    public function register(Request $request)
    {
        $user = User::create([
            'first_name'=> $request->input('first_name'),
            'last_name'=> $request->input('last_name'),
            'email'=> $request->input('email'),
            'password'=> Hash::make($request->input('password'))
        ]);

        SendWelcomeEmailJob::dispatch($user);

        return $user;
    }

    public function loginUser(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        return Auth::attempt(['email' => $email, 'password' => $password]);
    }
}
