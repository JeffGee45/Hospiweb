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
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@hospiweb.com',
                'password' => bcrypt('password'),
                'role' => 'Admin',
            ],
            [
                'name' => 'Doctor User',
                'email' => 'doctor@hospiweb.com',
                'password' => bcrypt('password'),
                'role' => 'Médecin',
            ],
            [
                'name' => 'Nurse User',
                'email' => 'nurse@hospiweb.com',
                'password' => bcrypt('password'),
                'role' => 'Infirmier',
            ],
            [
                'name' => 'Pharmacist User',
                'email' => 'pharmacist@hospiweb.com',
                'password' => bcrypt('password'),
                'role' => 'Pharmacien',
            ],
            [
                'name' => 'Cashier User',
                'email' => 'cashier@hospiweb.com',
                'password' => bcrypt('password'),
                'role' => 'Caissier',
            ],
            [
                'name' => 'Secretary User',
                'email' => 'secretary@hospiweb.com',
                'password' => bcrypt('password'),
                'role' => 'Secretaire',
            ],
        ];

        foreach ($users as $userData) {
            \App\Models\User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Tous les utilisateurs sont maintenant gérés via la boucle ci-dessus
    }
}
