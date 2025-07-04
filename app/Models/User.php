<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\RendezVous;
use App\Models\Patient;
use App\Models\Consultation;

class User extends Authenticatable
{
    /**
     * Vérifie si ce médecin a déjà eu une consultation avec ce patient.
     * @param int $patientId
     * @return bool
     */
    public function isMyPatient($patientId)
    {
        if ($this->role !== 'Médecin') return false;
        // Vérifie si ce médecin a déjà eu une consultation avec ce patient
        return \App\Models\Consultation::where('medecin_id', $this->id)
            ->where('patient_id', $patientId)
            ->exists();
    }

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'telephone',
        'adresse',
        'photo',
        'is_active',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Rôles disponibles dans l'application
     *
     * @var array
     */
    public static $roles = [
        'Admin' => 'Administrateur',
        'Médecin' => 'Médecin',
        'Infirmier' => 'Infirmier(e)',
        'Secrétaire' => 'Secrétaire',
        'Pharmacien' => 'Pharmacien',
        'Caissier' => 'Caissier'
    ];

    /**
     * Vérifie si l'utilisateur a un rôle spécifique
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Vérifie si l'utilisateur a l'un des rôles spécifiés
     *
     * @param array $roles
     * @return bool
     */
    public function hasAnyRole(array $roles)
    {
        return in_array($this->role, $roles);
    }

    /**
     * Vérifie si l'utilisateur est administrateur
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('Admin');
    }

    /**
     * Vérifie si l'utilisateur est un membre du personnel
     *
     * @return bool
     */
    public function isStaff()
    {
        return in_array($this->role, ['Médecin', 'Infirmier', 'Secrétaire', 'Pharmacien', 'Caissier']);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
    
    /**
     * Get the rendez-vous where the user is the doctor
     */
    public function rendezVousMedecin()
    {
        return $this->hasMany(RendezVous::class, 'medecin_id');
    }
    
    /**
     * Alias pour la relation consultations (compatibilité avec le code existant)
     */
    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'medecin_id');
    }
    
    /**
     * Get the rendez-vous where the user is the patient
     */
    public function rendezVousPatient()
    {
        return $this->hasMany(RendezVous::class, 'patient_id');
    }
    
    /**
     * Get the patient record associated with the user
     */
    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id');
    }
    
    // La méthode hasRole est déjà définie plus haut dans le fichier
}
