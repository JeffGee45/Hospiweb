<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('fr_FR');
        
        // Création des utilisateurs avec des rôles fixes pour les comptes principaux
        $users = [
            [
                'name' => 'Administrateur Principal',
                'email' => 'admin@hospiweb.com',
                'password' => bcrypt('password'),
                'role' => 'Admin',
                'telephone' => '0123456789',
                'adresse' => '1 Rue de l\'Hôpital, 75000 Paris',
                'is_active' => true
            ],
            [
                'name' => 'Dr. Martin Dupont',
                'email' => 'medecin@hospiweb.com',
                'password' => bcrypt('password'),
                'role' => 'Médecin',
                'telephone' => '0234567890',
                'adresse' => '2 Rue de la Clinique, 75000 Paris',
                'is_active' => true
            ],
            [
                'name' => 'Sophie Martin',
                'email' => 'infirmier@hospiweb.com',
                'password' => bcrypt('password'),
                'role' => 'Infirmier',
                'telephone' => '0345678901',
                'adresse' => '3 Rue des Soins, 75000 Paris',
                'is_active' => true
            ],
            [
                'name' => 'Marie Dubois',
                'email' => 'secretaire@hospiweb.com',
                'password' => bcrypt('password'),
                'role' => 'Secretaire',
                'telephone' => '0456789012',
                'adresse' => '4 Rue du Bureau, 75000 Paris',
                'is_active' => true
            ],
            [
                'name' => 'Pierre Durand',
                'email' => 'caissier@hospiweb.com',
                'password' => bcrypt('password'),
                'role' => 'Caissier',
                'telephone' => '0567890123',
                'adresse' => '5 Rue de la Caisse, 75000 Paris',
                'is_active' => true
            ]
        ];

        // Création des utilisateurs principaux
        foreach ($users as $userData) {
            User::create($userData);
        }

        // Création d'utilisateurs supplémentaires du personnel (pas de patients ici)
        $roles = ['Médecin', 'Infirmier', 'Secretaire', 'Caissier'];
        $domains = ['hospiweb.com', 'hopital.fr', 'clinique.fr', 'sante.fr'];
        
        // Créer 5 utilisateurs du personnel supplémentaire
        for ($i = 0; $i < 5; $i++) {
            $gender = $faker->randomElement(['M', 'F']);
            $firstName = $gender === 'M' ? $faker->firstNameMale : $faker->firstNameFemale;
            $lastName = $faker->lastName;
            $domain = $faker->randomElement($domains);
            $firstLetter = $this->slugify(mb_substr($firstName, 0, 1));
            $lastNameSlug = $this->slugify($lastName);
            $email = strtolower($firstLetter . '.' . $lastNameSlug . '@' . $domain);
            
            // Pour les médecins, ajouter le préfixe Dr.
            $name = $faker->randomElement($roles) === 'Médecin' 
                ? 'Dr. ' . $firstName . ' ' . $lastName
                : $firstName . ' ' . $lastName;
            
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt('password'),
                'role' => $faker->randomElement($roles),
                'telephone' => '0' . $faker->numberBetween(100000000, 999999999),
                'adresse' => $faker->streetAddress . ', ' . $faker->postcode . ' ' . $faker->city,
                'is_active' => true,
                'photo' => $faker->optional(0.3)->imageUrl(200, 200, 'people', true, 'portrait')
            ]);
        }
    }

    /**
     * Transforme une chaîne en ASCII (retire accents et caractères spéciaux)
     */
    private function slugify($string)
    {
        $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
        return preg_replace('/[^a-zA-Z0-9]/', '', $string);
    }
}
