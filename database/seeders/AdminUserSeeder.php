<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Exécute le seeder pour créer un administrateur.
     */

     
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@hospiweb.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Mot de passe par défaut : password
            'role' => 'Admin',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Utilisateur administrateur créé avec succès !');
        $this->command->info('Email: admin@hospiweb.com');
        $this->command->info('Mot de passe: password');
    }
}
