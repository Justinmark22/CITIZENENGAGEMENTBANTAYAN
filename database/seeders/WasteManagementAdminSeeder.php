<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class WasteManagementAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            [
                'name' => 'Bantayan Waste Admin',
                'email' => 'bantayan.waste@local',
                'password' => Hash::make('password123'),
                'role' => 'waste',
                'location' => 'Bantayan',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Santa Fe Waste Admin',
                'email' => 'santafe.waste@local',
                'password' => Hash::make('password123'),
                'role' => 'waste',
                'location' => 'Santa.Fe',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Madridejos Waste Admin',
                'email' => 'madridejos.waste@local',
                'password' => Hash::make('password123'),
                'role' => 'waste',
                'location' => 'Madridejos',
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
