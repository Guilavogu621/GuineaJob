<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
        'must_change_password',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'must_change_password' => 'boolean',
        ];
    }

    // Accesseur pour le nom complet
    public function getFullNameAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    // Vérification des rôles
    public function isAdmin() { return $this->hasRole('admin'); }
    public function isEmployeur() { return $this->hasRole('employeur'); }
    public function isEmploye() { return $this->hasRole('employe'); }
    public function isCandidat() { return $this->hasRole('candidat'); }
    public function isPrestataire() { return $this->hasRole('prestataire'); }

    // Relations
    public function entreprise()
    {
        return $this->hasOne(Entreprise::class);
    }

    public function employe()
    {
        return $this->hasOne(Employe::class);
    }

    /**
     * Les candidatures déposées par l'utilisateur (si candidat).
     */
    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }
}
