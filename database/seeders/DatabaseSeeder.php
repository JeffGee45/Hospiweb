<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Les seeders sont exécutés dans l'ordre de dépendance
        $this->call([
            UserSeeder::class,
            TypeExamenSeeder::class,
            ParametreExamenSeeder::class,
            // Ajoutez d'autres seeders ici si nécessaire
        ]);

        // Si vous avez besoin de créer un utilisateur de test supplémentaire
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
