<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendWelcomeEmailJob;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function getUserName($userId): string
    {
        $user = User::find($userId);

        if ($user) {
            return "Tên admin: {$user->name}";
        }

        return "User not found";
    }

    public function register(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => '0'
        ]);

        SendWelcomeEmailJob::dispatch($user);

        return $user;
    }

    public function loginUser($data)
    {
        $email = $data['email'];
        $password = $data['password'];

        return Auth::attempt(['email' => $email, 'password' => $password]);
    }
}