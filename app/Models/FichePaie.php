<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modèle FichePaie (CDC: Or #BA7517 — Paie).
 * Relations : N-1 Contrat, N-1 Employe.
 * Calcul automatique : CNSS 5%, AGUIPE 1%.
 */
class FichePaie extends Model
{
    protected $fillable = [
        'employe_id',
        'contrat_id',
        'mois',
        'salaire_brut',
        'cnss',
        'aguipe',
        'autres_deductions',
        'salaire_net',
    ];

    protected $casts = [
        'mois' => 'date',
        'salaire_brut' => 'decimal:2',
        'cnss' => 'decimal:2',
        'aguipe' => 'decimal:2',
        'autres_deductions' => 'decimal:2',
        'salaire_net' => 'decimal:2',
    ];

    /** Taux légaux guinéens */
    const TAUX_CNSS = 0.05;    // 5%
    const TAUX_AGUIPE = 0.01;  // 1%

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }

    public function contrat()
    {
        return $this->belongsTo(Contrat::class);
    }
}
