<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Enums\AuthStatus;
use App\Http\Resources\Admin\UserResource;

class UserService
{
    public function adminCreateUser(array $data)
    {
        try {
            $user = User::create($data);
            return $user;
        } catch (\Exception $e) {
            Log::error('User creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function adminUpdateUser(User $user, array $data)
    {
        try {
            if ($data['email'] === $user->email) {
                unset($data['email']);
            }
            $user->update($data);
            return $user;
        } catch (\Exception $e) {
            Log::error('User update failed: ' . $e->getMessage());
            throw $e;
        }
    }
    
    public function getAdminUserData(array $data)
    {
        $query = User::select('users.*');
    
        $searchValue = $data['search_text'] ?? null; 
        $searchStatus = isset($data['status']) && $data['status'] !== '' ? (int)$data['status'] : null;
    
        if (!empty($searchValue) || !is_null($searchStatus)) {
            $query->where(function ($q) use ($searchValue, $searchStatus) {
                if (!empty($searchValue)) {
                    $q->whereAny(['first_name', 'last_name', 'email'], 'like', "%{$searchValue}%");
                }
                if (!is_null($searchStatus)) {
                    $q->where('status', '=', $searchStatus);
                }
            });
        }
    
        $query->orderBy('created_at', 'desc');
    
        $length = (int)($data['length'] ?? 5);
        $start = (int)($data['start'] ?? 0);
        $page = ($start / $length) + 1;
    
        $users = $query->paginate($length, ['*'], 'page', $page);
    
        $dataCollection = UserResource::collection($users);
    
        return [
            'draw' => (int)($data['draw'] ?? 0),
            'recordsTotal' => $users->total(),
            'recordsFiltered' => $users->total(),
            'data' => $dataCollection
        ];
    }

    public function toggleLock(User $user)
    {
        $newStatus = $user->status === AuthStatus::LOCKED ? AuthStatus::APPROVED : AuthStatus::LOCKED;
        $user->update(['status' => $newStatus]);

        $message = $newStatus === AuthStatus::APPROVED ? 'Mở khóa tài khoản thành công.' : 'Khóa tài khoản thành công.';
        return [
            'success' => true,
            'message' => $message
        ];
    }
}
