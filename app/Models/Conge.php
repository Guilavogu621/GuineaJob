<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conge extends Model
{
    // Statuts de la demande de congé
    const STATUS_PENDING = 'en_attente';
    const STATUS_APPROVED = 'valide';
    const STATUS_REJECTED = 'refuse';

    protected $fillable = [
        'employe_id',
        'type_conge',
        'date_debut',
        'date_fin',
        'jours_deduits',
        'motif',
        'statut',
        'reponse_employeur',
        'valide_par',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'jours_deduits' => 'decimal:2',
    ];

    /**
     * L'employé associé à cette demande.
     */
    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }

    /**
     * L'utilisateur qui a validé/refusé la demande (CDC: valide_par FK → users).
     */
    public function validePar()
    {
        return $this->belongsTo(User::class, 'valide_par');
    }
}
