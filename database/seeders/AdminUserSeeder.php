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
        // Create admin user
        $admin = \App\Models\User::create([
            'name' => 'Administrateur',
            'email' => 'admin@hospiweb.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Mot de passe par défaut : password
            'role' => 'Admin',
            'telephone' => '+1234567890',
            'adresse' => '123 Rue Admin, Ville',
            'photo' => null,
            'is_active' => true,
            'last_login_at' => now(),
            'last_login_ip' => '127.0.0.1',
            'remember_token' => Str::random(10),
        ]);

        // Create a sample doctor
        $doctor = \App\Models\User::create([
            'name' => 'Dr. Jean Dupont',
            'email' => 'jean.dupont@hospiweb.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'Medecin',
            'telephone' => '+1987654321',
            'adresse' => '456 Rue des Médecins, Ville',
            'photo' => null,
            'is_active' => true,
            'remember_token' => Str::random(10),
        ]);

        // Create a sample secretary
        $secretary = \App\Models\User::create([
            'name' => 'Marie Martin',
            'email' => 'marie.martin@hospiweb.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'Secretaire',
            'telephone' => '+1122334455',
            'adresse' => '789 Rue des Secrétaires, Ville',
            'photo' => null,
            'is_active' => true,
            'remember_token' => Str::random(10),
        ]);

        // Create a sample patient
        $patientUser = \App\Models\User::create([
            'name' => 'Pierre Dubois',
            'email' => 'pierre.dubois@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'Patient',
            'telephone' => '+5566778899',
            'adresse' => '321 Rue des Patients, Ville',
            'photo' => null,
            'is_active' => true,
            'remember_token' => Str::random(10),
        ]);

        // Create patient record
        $patient = \App\Models\Patient::create([
            'user_id' => $patientUser->id,
            'numero_dossier' => 'PAT' . strtoupper(Str::random(8)),
            'date_naissance' => '1985-07-15',
            'lieu_naissance' => 'Paris, France',
            'sexe' => 'M',
            'adresse' => '321 Rue des Patients, Ville',
            'telephone' => '+5566778899',
            'profession' => 'Ingénieur',
            'groupe_sanguin' => 'A+',
            'allergies' => json_encode(['Pollen', 'Arachides']),
            'antecedents_medicaux' => json_encode(['Hypertension']),
            'traitements_en_cours' => json_encode(['Médicament X']),
            'nom_contact_urgence' => 'Sophie Dubois',
            'telephone_contact_urgence' => '+5566778800',
            'lien_contact_urgence' => 'Épouse',
            'notes' => 'Patient régulier depuis 2020',
            'statut' => 'actif',
        ]);

        $this->command->info('=== Comptes de démonstration créés avec succès ===');
        $this->command->info('');
        $this->command->info('=== Administrateur ===');
        $this->command->info('Email: admin@hospiweb.com');
        $this->command->info('Mot de passe: password');
        $this->command->info('Role: Admin');
        $this->command->info('');
        $this->command->info('=== Médecin ===');
        $this->command->info('Email: jean.dupont@hospiweb.com');
        $this->command->info('Mot de passe: password');
        $this->command->info('Role: Medecin');
        $this->command->info('');
        $this->command->info('=== Secrétaire ===');
        $this->command->info('Email: marie.martin@hospiweb.com');
        $this->command->info('Mot de passe: password');
        $this->command->info('Role: Secretaire');
        $this->command->info('');
        $this->command->info('=== Patient ===');
        $this->command->info('Email: pierre.dubois@example.com');
        $this->command->info('Mot de passe: password');
        $this->command->info('Role: Patient');
        $this->command->info('');
        $this->command->info('==================================');
        $this->command->info('Conseil de sécurité : Changez ces mots de passe après la première connexion !');
    }
}
