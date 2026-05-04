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
    public function isAdmin() { return $this->role === 'admin'; }
    public function isEmployeur() { return $this->role === 'employeur'; }
    public function isEmploye() { return $this->role === 'employe'; }
    public function isCandidat() { return $this->role === 'candidat'; }
    public function isPrestataire() { return $this->role === 'prestataire'; }

    // Relations
    public function entreprise()
    {
        return $this->hasOne(Entreprise::class);
    }

    public function employe()
    {
        return $this->hasOne(Employe::class);
    }
}
