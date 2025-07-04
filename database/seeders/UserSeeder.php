<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Création d'un administrateur
        User::create([
            'name' => 'Administrateur Principal',
            'email' => 'admin@hospiweb.com',
            'password' => bcrypt('password'),
            'role' => 'Admin',
            'telephone' => '0123456789',
            'adresse' => '1 Rue de l\'Hôpital, 75000 Paris',
            'is_active' => true
        ]);

        // Création d'un médecin
        User::create([
            'name' => 'Dr. Martin Dupont',
            'email' => 'medecin@hospiweb.com',
            'password' => bcrypt('password'),
            'role' => 'Médecin',
            'telephone' => '0234567890',
            'adresse' => '2 Rue de la Clinique, 75000 Paris',
            'is_active' => true
        ]);

        // Création d'un infirmier
        User::create([
            'name' => 'Sophie Martin',
            'email' => 'infirmier@hospiweb.com',
            'password' => bcrypt('password'),
            'role' => 'Infirmier',
            'telephone' => '0345678901',
            'adresse' => '3 Rue des Soins, 75000 Paris',
            'is_active' => true
        ]);

        // Création d'une secrétaire
        User::create([
            'name' => 'Julie Bernard',
            'email' => 'secretaire@hospiweb.com',
            'password' => bcrypt('password'),
            'role' => 'Secrétaire',
            'telephone' => '0456789012',
            'adresse' => '4 Rue du Bureau, 75000 Paris',
            'is_active' => true
        ]);

        // Création d'un pharmacien
        User::create([
            'name' => 'Thomas Leroy',
            'email' => 'pharmacien@hospiweb.com',
            'password' => bcrypt('password'),
            'role' => 'Pharmacien',
            'telephone' => '0567890123',
            'adresse' => '5 Rue de la Pharmacie, 75000 Paris',
            'is_active' => true
        ]);

        // Création d'un caissier
        User::create([
            'name' => 'Léa Petit',
            'email' => 'caissier@hospiweb.com',
            'password' => bcrypt('password'),
            'role' => 'Caissier',
            'telephone' => '0678901234',
            'adresse' => '6 Rue de la Caisse, 75000 Paris',
            'is_active' => true
        ]);

        // Note: Suppression de la création d'un utilisateur Patient comme demandé
    }
}
