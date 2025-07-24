<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendWelcomeEmailJob;
use App\Jobs\SendForgotPassJob;
use Illuminate\Support\Facades\Auth;
use App\Enums\AuthStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthService
{
    public function register(array $data)
    {
        try {
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            SendWelcomeEmailJob::dispatch($user);
            return $user;
        } catch (\Exception $e) {
            Log::error('Đăng ký thất bại: ' . $e->getMessage());
            return false;
        }
    }

    public function loginUser(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();
    
        if ($user->status !== AuthStatus::APPROVED) {
            session()->flash('status_error', $user->status_label);
            return false;
        }
    
        if (Auth::attempt($credentials)) {
            return $user;
        }
    
        return false;
    }
    

    public function forgotPassword(string $email)
    {
        try {
            $user = User::where('email', $email)->first();
            $token = Str::random(60);

            DB::table('password_reset_tokens')->updateOrInsert(
                [
                    'email' => $email,
                    'token' => $token,
                    'created_at' => now()
                ]
            );

            SendForgotPassJob::dispatch($user, $token);
            return true;
        } catch (\Exception $e) {
            Log::error('Reset password failed: ' . $e->getMessage());
            return false;
        }
    }

    public function resetPassword(string $token, string $password)
    {
        try {
            $passwordReset = DB::table('password_reset_tokens')
                ->where('token', $token)
                ->first();

            if (!$passwordReset) {
                return false;
            }

            $user = User::where('email', $passwordReset->email)->first();
            if (!$user) {
                return false;
            }

            $user->update(['password' => Hash::make($password)]);

            DB::table('password_reset_tokens')
                ->where('email', $passwordReset->email)
                ->delete();

            return true;
        } catch (\Exception $e) {
            Log::error('Reset password failed: ' . $e->getMessage());
            return false;
        }
    }

    public function updateProfile(array $data)
    {
        try {
            $user = Auth::user();
            $user->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'address' => $data['address']
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('Cập nhật hồ sơ thất bại: ' . $e->getMessage());
            return false;
        }
    }
}
