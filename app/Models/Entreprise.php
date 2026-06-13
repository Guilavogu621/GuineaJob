<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    protected $fillable = [
        'user_id',
        'raison_sociale',
        'secteur',
        'adresse',
        'telephone',
        'logo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employes()
    {
        return $this->hasMany(Employe::class);
    }

    /**
     * Les offres d'emploi publiées par l'entreprise.
     */
    public function offresEmploi()
    {
        return $this->hasMany(OffreEmploi::class);
    }

    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }

    /**
     * Les appels d'offres publiés par l'entreprise (B2B).
     */
    public function appelsOffres()
    {
        return $this->hasMany(AppelOffre::class);
    }

    /**
     * Les propositions faites par l'entreprise sur d'autres appels d'offres.
     */
    public function propositionsEnvoyees()
    {
        return $this->hasMany(PropositionOffre::class, 'entreprise_prestataire_id');
    }
}
