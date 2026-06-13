<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidature extends Model
{
    use HasFactory;

    // Statuts de la candidature
    const STATUS_PENDING = 'en_attente';
    const STATUS_RETAINED = 'retenu';
    const STATUS_REJECTED = 'rejete';
    const STATUS_INTERVIEW = 'entretien';
    const STATUS_HIRED = 'embauche';

    protected $fillable = [
        'offre_emploi_id',
        'user_id',
        'cv_path',
        'lettre_motivation_path',
        'commentaire_candidat',
        'statut',
        'note_employeur'
    ];

    /**
     * L'offre d'emploi concernée.
     */
    public function offre(): BelongsTo
    {
        return $this->belongsTo(OffreEmploi::class, 'offre_emploi_id');
    }

    /**
     * Alias pour compatibilité avec les vues (offreEmploi).
     */
    public function offreEmploi(): BelongsTo
    {
        return $this->belongsTo(OffreEmploi::class, 'offre_emploi_id');
    }

    /**
     * Le candidat qui a postulé.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
