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

    public function contrats()
    {
        return $this->hasMany(Contrat::class);
    }
}
