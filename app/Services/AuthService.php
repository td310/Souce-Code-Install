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
    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'status' => AuthStatus::PENDING
            ]);

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
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->status === AuthStatus::APPROVED) {
                return true;
            }
            Auth::logout();
            return false;
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
}
