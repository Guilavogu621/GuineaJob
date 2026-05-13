<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conge extends Model
{
    protected $fillable = [
        'employe_id',
        'type_conge',
        'date_debut',
        'date_fin',
        'jours_deduits',
        'motif',
        'statut',
        'reponse_employeur'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'jours_deduits' => 'decimal:2',
    ];

    /**
     * Obtenir l'employé associé à cette demande de congé.
     */
    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }
}
