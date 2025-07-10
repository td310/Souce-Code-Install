<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\AuthRole;

class AdminPostPolicy
{
    public function adminAccess(User $user): bool
    {
        return $user->role === AuthRole::ADMIN;
    }
}