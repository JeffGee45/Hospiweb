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
    
    /**
     * Check if the user has a specific role
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
