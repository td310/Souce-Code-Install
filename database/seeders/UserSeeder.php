<?php

namespace Database\Seeders;

use App\Enums\AuthStatus;
use App\Enums\AuthRole;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin02@khgc.com',
            'password' => Hash::make('Abcd@1234'), 
            'address' => null, 
            'status' => AuthStatus::PENDING,
            'role' => AuthRole::ADMIN,
        ]);
    }
}
