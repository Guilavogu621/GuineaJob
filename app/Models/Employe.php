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
}
