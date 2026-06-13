<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropositionOffre extends Model
{
    use HasFactory;

    protected $table = 'propositions_offres';

    // Statuts de la proposition
    const STATUS_PENDING = 'en_attente';
    const STATUS_UNDER_REVIEW = 'en_examen';
    const STATUS_ACCEPTED = 'retenu';
    const STATUS_REJECTED = 'rejete';

    protected $fillable = [
        'appel_offre_id',
        'entreprise_prestataire_id',
        'montant_propose',
        'delai_execution',
        'message_accompagnement',
        'document_proposition',
        'statut',
        'note_interne'
    ];

    /**
     * L'appel d'offre concerné.
     */
    public function appelOffre(): BelongsTo
    {
        return $this->belongsTo(AppelOffre::class);
    }

    /**
     * L'entreprise qui propose ses services.
     */
    public function prestataire(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class, 'entreprise_prestataire_id');
    }
}
