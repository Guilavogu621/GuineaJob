<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $fillable = [
        'user_id',
        'entreprise_id',
        'poste',
        'date_embauche',
        'numero_matricule',
        'date_naissance',
        'lieu_naissance',
        'genre',
        'adresse',
        'telephone',
        'type_contrat',
        'salaire_base',
    ];

    protected $casts = [
        'date_embauche' => 'date',
        'date_naissance' => 'date',
    ];

    /**
     * Logique automatique à la création
     */
    protected static function booted()
    {
        static::creating(function ($employe) {
            if (!$employe->numero_matricule) {
                $employe->numero_matricule = 'EMP-' . strtoupper(\Illuminate\Support\Str::random(6));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }

    /**
     * Les demandes de congés de l'employé.
     */
    public function conges()
    {
        return $this->hasMany(Conge::class);
    }

    /**
     * Les fiches de paie de l'employé.
     */
    public function fichesPaie()
    {
        return $this->hasMany(FichePaie::class);
    }
}
