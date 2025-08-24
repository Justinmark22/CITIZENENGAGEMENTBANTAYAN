<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Or App\Models\Admin if using a separate Admin model

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // Ensure no duplication
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('thisisadmin00'), // Secure password
                'location' => 'admin', // Ensure your users table has a 'role' column or similar
            ]
        );
    }
}
