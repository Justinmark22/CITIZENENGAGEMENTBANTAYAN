<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class WaterManagementAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'name' => 'Bantayan Water Admin',
                'email' => 'bantayan.water@local',
                'password' => Hash::make('password123'),
                'role' => 'water',
                'location' => 'Bantayan',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Santa Fe Water Admin',
                'email' => 'santafe.water@local',
                'password' => Hash::make('password123'),
                'role' => 'water',
                'location' => 'Santa.Fe',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Madridejos Water Admin',
                'email' => 'madridejos.water@local',
                'password' => Hash::make('password123'),
                'role' => 'water',
                'location' => 'Madridejos',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
