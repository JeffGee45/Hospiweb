<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@hospiweb.com',
            'password' => bcrypt('password'),
            'role' => 'Admin',
        ]);

        \App\Models\User::create([
            'name' => 'Doctor User',
            'email' => 'doctor@hospiweb.com',
            'password' => bcrypt('password'),
            'role' => 'Medecin',
        ]);

        \App\Models\User::create([
            'name' => 'Nurse User',
            'email' => 'nurse@hospiweb.com',
            'password' => bcrypt('password'),
            'role' => 'Infirmier',
        ]);

        \App\Models\User::create([
            'name' => 'Pharmacist User',
            'email' => 'pharmacist@hospiweb.com',
            'password' => bcrypt('password'),
            'role' => 'Pharmacien',
        ]);

        \App\Models\User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@hospiweb.com',
            'password' => bcrypt('password'),
            'role' => 'Caissier',
        ]);

        \App\Models\User::create([
            'name' => 'Secretary User',
            'email' => 'secretary@hospiweb.com',
            'password' => bcrypt('password'),
            'role' => 'Secretaire',
        ]);
    }
}
