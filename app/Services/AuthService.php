<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendWelcomeEmailJob;
use App\Jobs\SendForgotPassJob;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Enums\AuthStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthService
{
    public function register(array $data)
    {
        DB::beginTransaction();
        try {
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            SendWelcomeEmailJob::dispatch($user);
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Đăng ký thất bại: ' . $e->getMessage());
            return false;
        }
    }

    public function loginUser(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();
        if ($user) {
            if ($user->status === AuthStatus::APPROVED) {
                if (Auth::attempt($credentials)) {
                    return true;
                }
            } else {
                session()->flash('status_error', $user->status_label);
            }
        }
        return false;
    }

    public function forgotPassword(string $email)
    {
        DB::beginTransaction();
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
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reset password failed: ' . $e->getMessage());
            return false;
        }
    }

    public function resetPassword(string $token, string $password)
    {
        DB::beginTransaction();
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

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reset password failed: ' . $e->getMessage());
            return false;
        }
    }

    public function updateProfile(array $data)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $user->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'address' => $data['address']
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Cập nhật hồ sơ thất bại: ' . $e->getMessage());
            return false;
        }
    }
}
