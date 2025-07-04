<?php

namespace App\Helpers;

class RoleHelper
{
    /**
     * Liste des rôles disponibles avec leurs libellés
     */
    public static function getRoles()
    {
        return [
            'Admin' => 'Administrateur',
            'Médecin' => 'Médecin',
            'Infirmier' => 'Infirmier(e)',
            'Secrétaire' => 'Secrétaire',
            'Pharmacien' => 'Pharmacien',
            'Caissier' => 'Caissier',
            'Patient' => 'Patient',
        ];
    }

    /**
     * Vérifie si l'utilisateur a un des rôles spécifiés
     */
    public static function hasRole($user, $roles)
    {
        if (!is_array($roles)) {
            $roles = [$roles];
        }
        
        return in_array($user->role, $roles);
    }

    /**
     * Vérifie si l'utilisateur est un membre du personnel
     */
    public static function isStaff($user)
    {
        return in_array($user->role, ['Médecin', 'Infirmier', 'Secrétaire', 'Pharmacien', 'Caissier']);
    }

    /**
     * Récupère le libellé d'un rôle
     */
    public static function getRoleLabel($role)
    {
        $roles = self::getRoles();
        return $roles[$role] ?? $role;
    }
}
