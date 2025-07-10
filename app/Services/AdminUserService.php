<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminUserService
{
    public function adminCreateUser(array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::create($data);
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User creation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function adminUpdateUser(User $user, array $data)
    {
        DB::beginTransaction();
        try {
            if ($data['email'] === $user->email) {
                unset($data['email']);
            }
            $user->update($data);
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User update failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function adminDeleteUser(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('User deletion failed: ' . $e->getMessage());
            return false;
        }
    }

    public function getAdminUserData(Request $request)
    {
        $query = User::query();

        $searchValue = $request->input('search.value');
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$searchValue}%"])
                    ->orWhere('email', 'like', "%{$searchValue}%");
            });
        }

        $query->orderBy('created_at', 'desc');

        $length = $request->input('length', 5);
        $start = ($request->input('start', 0) / $length) + 1;

        $users = $query->paginate($length, ['*'], 'page', $start);

        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'address' => $user->address,
                'status_label' => $user->status_label,
            ];
        });

        return [
            'draw' => $request->input('draw'),
            'recordsTotal' => $users->total(),
            'recordsFiltered' => $users->total(),
            'data' => $data
        ];
    }
}
