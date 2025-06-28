<?php

namespace App\Helpers;

class StatusHelper
{
    /**
     * Retourne la classe CSS Bootstrap pour un statut de rendez-vous.
     *
     * @param string $status
     * @return string
     */
    public static function rdvStatusClass(string $status): string
    {
        return match (strtolower($status)) {
            'confirmé', 'confirme' => 'success',
            'en_attente' => 'warning',
            'annulé', 'annule' => 'danger',
            'terminé' => 'secondary',
            'manqué' => 'dark',
            default => 'primary',
        };
    }
}
