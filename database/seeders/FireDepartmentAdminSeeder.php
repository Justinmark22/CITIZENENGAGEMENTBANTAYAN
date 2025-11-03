<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class FireDepartmentAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'name' => 'Bantayan Fire Admin',
                'email' => 'bantayan.fire@local',
                'password' => Hash::make('password123'),
                'role' => 'fire',
                'location' => 'Bantayan',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Santa Fe Fire Admin',
                'email' => 'santafe.fire@local',
                'password' => Hash::make('password123'),
                'role' => 'fire',
                'location' => 'Santa.Fe',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Madridejos Fire Admin',
                'email' => 'madridejos.fire@local',
                'password' => Hash::make('password123'),
                'role' => 'fire',
                'location' => 'Madridejos',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
