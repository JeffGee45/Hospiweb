<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_users_with_different_roles()
    {
        // Création d'un utilisateur avec chaque rôle
        $roles = [
            'Admin' => 'Administrateur',
            'Médecin' => 'Médecin',
            'Infirmier' => 'Infirmier(e)',
            'Secrétaire' => 'Secrétaire',
            'Pharmacien' => 'Pharmacien',
            'Caissier' => 'Caissier',
            'Patient' => 'Patient',
        ];

        foreach ($roles as $role => $label) {
            $user = User::factory()->create(['role' => $role]);
            $this->assertEquals($role, $user->role);
            $this->assertEquals($label, $user->role); // Le libellé devrait correspondre
        }
    }

    /** @test */
    public function it_can_check_user_roles()
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $medecin = User::factory()->create(['role' => 'Médecin']);
        $patient = User::factory()->create(['role' => 'Patient']);

        // Vérification des rôles
        $this->assertTrue($admin->hasRole('Admin'));
        $this->assertTrue($medecin->hasRole('Médecin'));
        $this->assertTrue($patient->hasRole('Patient'));
        $this->assertFalse($patient->hasRole('Admin'));

        // Vérification de la méthode isAdmin
        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($medecin->isAdmin());

        // Vérification de la méthode isStaff
        $this->assertTrue($admin->isStaff());
        $this->assertTrue($medecin->isStaff());
        $this->assertFalse($patient->isStaff());
    }

    /** @test */
    public function it_can_use_role_helper()
    {
        $roles = \App\Helpers\RoleHelper::getRoles();
        
        $this->assertArrayHasKey('Admin', $roles);
        $this->assertArrayHasKey('Médecin', $roles);
        $this->assertArrayHasKey('Infirmier', $roles);
        $this->assertArrayHasKey('Secrétaire', $roles);
        $this->assertArrayHasKey('Pharmacien', $roles);
        $this->assertArrayHasKey('Caissier', $roles);
        $this->assertArrayHasKey('Patient', $roles);

        // Vérification des libellés
        $this->assertEquals('Administrateur', $roles['Admin']);
        $this->assertEquals('Médecin', $roles['Médecin']);
        $this->assertEquals('Infirmier(e)', $roles['Infirmier']);
        $this->assertEquals('Secrétaire', $roles['Secrétaire']);
    }
}
