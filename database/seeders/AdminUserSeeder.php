<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // ✅ Ensure this points to your User model

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // Prevent duplicate entries
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('thisisadmin00'), // Secure password
                'role' => 'admin', // ✅ Added role field
                'location' => 'Admin', // ✅ Optional: matches your redirect logic
                'status' => 'active', // ✅ Optional: ensures active login
            ]
        );
    }
}
