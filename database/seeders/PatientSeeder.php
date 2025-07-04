<?php

namespace Database\Seeders;

use App\Models\Patient;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('fr_FR');
        
        // Liste de prénoms et noms français courants
        $prenomsHommes = [
            'Jean', 'Pierre', 'Michel', 'André', 'René', 'Claude', 'Bernard', 'Jacques', 
            'Philippe', 'Alain', 'Nicolas', 'Thomas', 'François', 'David', 'Christophe'
        ];
        
        $prenomsFemmes = [
            'Marie', 'Jeanne', 'Françoise', 'Monique', 'Nathalie', 'Isabelle', 'Sylvie',
            'Martine', 'Catherine', 'Christine', 'Sophie', 'Valérie', 'Sandrine', 'Élodie'
        ];
        
        $noms = [
            'Martin', 'Bernard', 'Dubois', 'Thomas', 'Robert', 'Richard', 'Petit', 'Durand',
            'Leroy', 'Moreau', 'Simon', 'Laurent', 'Lefebvre', 'Michel', 'Garcia', 'David',
            'Bertrand', 'Roux', 'Vincent', 'Fournier', 'Morel', 'Girard', 'Andre', 'Lefevre',
            'Mercier', 'Dupont', 'Lambert', 'Bonnet', 'Francois', 'Martinez'
        ];
        
        // Villes françaises avec codes postaux
        $villes = [
            ['Paris', '75000'], ['Marseille', '13000'], ['Lyon', '69000'], ['Toulouse', '31000'],
            ['Nice', '06000'], ['Nantes', '44000'], ['Strasbourg', '67000'], ['Montpellier', '34000'],
            ['Bordeaux', '33000'], ['Lille', '59000'], ['Rennes', '35000'], ['Reims', '51100'],
            ['Le Havre', '76600'], ['Saint-Étienne', '42000'], ['Toulon', '83000']
        ];
        
        // Créer 20 patients avec des données réalistes
        for ($i = 0; $i < 20; $i++) {
            $gender = $faker->randomElement(['M', 'F']);
            $prenoms = $gender === 'M' ? $prenomsHommes : $prenomsFemmes;
            $firstName = $faker->randomElement($prenoms);
            $lastName = $faker->randomElement($noms);
            
            // Générer un email sans accents ni caractères spéciaux
            $firstLetter = $this->slugify(mb_substr($firstName, 0, 1));
            $lastNameSlug = $this->slugify($lastName);
            $email = strtolower($firstLetter . '.' . $lastNameSlug . '@patient.hospiweb.fr');
            
            // Générer une date de naissance réaliste (entre 18 et 100 ans)
            $dateNaissance = $faker->dateTimeBetween('-100 years', '-18 years');
            $age = Carbon::now()->diffInYears($dateNaissance);
            
            // Sélectionner une ville aléatoire
            $ville = $faker->randomElement($villes);
            $adresse = $faker->streetAddress . ', ' . $ville[1] . ' ' . $ville[0];
            
            // Données médicales réalistes en fonction de l'âge
            $antecedents = [];
            $traitements = [];
            $allergies = [];

            if ($age > 50 && $faker->boolean(70)) {
                $antecedents[] = $faker->randomElement(['Hypertension artérielle', 'Diabète de type 2', 'Hypercholestérolémie']);
            }
            if ($age > 30 && $faker->boolean(40)) {
                $antecedents[] = $faker->randomElement(['Allergies saisonnières', 'Asthme', 'Migraines']);
            }
            if (!empty($antecedents) && $faker->boolean(70)) {
                $traitements[] = $faker->randomElement(['Antihypertenseurs', 'Statines', 'Antidiabétiques oraux']);
            }
            if ($faker->boolean(30)) {
                $allergies[] = $faker->randomElement(['Pénicilline', 'AINS', 'Arachides']);
            }

            // Créer le patient avec toutes ses données
            Patient::create([
                'nom' => $lastName,
                'prenom' => $firstName,
                'email' => $email,
                'numero_dossier' => 'PAT' . strtoupper($faker->unique()->bothify('#######')),
                'date_naissance' => $dateNaissance,
                'lieu_naissance' => $faker->city . ', France',
                'adresse' => $adresse,
                'telephone' => '0' . $faker->numberBetween(600000000, 799999999),
                'sexe' => $gender,
                'groupe_sanguin' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
                'allergies' => !empty($allergies) ? json_encode($allergies) : null,
                'antecedents_medicaux' => !empty($antecedents) ? json_encode($antecedents) : null,
                'traitements_en_cours' => !empty($traitements) ? json_encode($traitements) : null,
                'profession' => $this->getProfession($age, $gender, $faker),
                'nom_contact_urgence' => $faker->name,
                'telephone_contact_urgence' => '0' . $faker->numberBetween(600000000, 799999999),
                'lien_contact_urgence' => $faker->randomElement(['Conjoint(e)', 'Parent', 'Ami(e)']),
                'notes' => $faker->optional(0.3)->sentence,
                'statut' => $faker->randomElement(['actif', 'inactif']),
                'created_at' => now()->subDays(rand(1, 365)),
                'updated_at' => now()->subDays(rand(1, 365)),
            ]);
        }
        
        $this->command->info('20 patients avec des données réalistes ont été créés avec succès !');
    }

    /**
     * Transforme une chaîne en ASCII (retire accents et caractères spéciaux)
     */
    private function slugify($string)
    {
        $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
        return preg_replace('/[^a-zA-Z0-9]/', '', $string);
    }
    
    /**
     * Retourne une profession réaliste en fonction de l'âge et du genre
     */
    private function getProfession($age, $gender, $faker)
    {
        if ($age < 18) return 'Étudiant' . ($gender === 'F' ? 'e' : '');
        if ($age > 65) return $faker->optional(0.7, 'Retraité' . ($gender === 'F' ? 'e' : ''))->jobTitle;
        
        $metiers = [
            'Comptable', 'Enseignant' . ($gender === 'F' ? 'e' : ''), 'Infirmier' . ($gender === 'F' ? 'ère' : ''),
            'Ingénieur' . ($gender === 'F' ? 'e' : ''), 'Développeur' . ($gender === 'F' ? 'euse' : ''), 'Commercial' . ($gender === 'F' ? 'e' : ''),
            'Chef de projet', 'Responsable RH', 'Technicien' . ($gender === 'F' ? 'ne' : ''), 'Assistant' . ($gender === 'F' ? 'e' : '') . ' de direction',
            'Architecte', 'Designer', 'Journaliste', 'Médecin', 'Pharmacien' . ($gender === 'F' ? 'ne' : ''), 'Avocat' . ($gender === 'F' ? 'e' : '')
        ];
        
        return $faker->randomElement($metiers);
    }
}
