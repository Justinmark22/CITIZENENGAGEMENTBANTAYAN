<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Or use App\Models\Admin if you have a separate Admin model

class MDRRMOSeeder extends Seeder
{  public function run(): void
    {
        // Santa Fe
        User::updateOrCreate(
            ['email' => 'mdrrmo.santafe@bantayan.gov.ph'],
            [
                'name' => 'MDRRMO Santa Fe Officer',
                'password' => Hash::make('mdrrmo123'),
                'role' => 'mdrrmo',
                'location' => 'Santa.Fe',
            ]
        );

        // Bantayan
        User::updateOrCreate(
            ['email' => 'mdrrmo.bantayan@bantayan.gov.ph'],
            [
                'name' => 'MDRRMO Bantayan Officer',
                'password' => Hash::make('mdrrmo123'),
                'role' => 'mdrrmo',
                'location' => 'Bantayan',
            ]
        );

        // Madridejos
        User::updateOrCreate(
            ['email' => 'mdrrmo.madridejos@bantayan.gov.ph'],
            [
                'name' => 'MDRRMO Madridejos Officer',
                'password' => Hash::make('mdrrmo123'),
                'role' => 'mdrrmo',
                'location' => 'Madridejos',
            ]
        );
    }
}
