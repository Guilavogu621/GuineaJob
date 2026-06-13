<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AppelOffre extends Model
{
    use HasFactory;

    protected $table = 'appels_offres';

    // Statuts de l'appel d'offre
    const STATUS_PUBLISHED = 'publie';
    const STATUS_CLOSED = 'cloture';
    const STATUS_AWARDED = 'attribue';
    const STATUS_CANCELLED = 'annule';

    protected $fillable = [
        'entreprise_id',
        'titre',
        'description',
        'secteur_activite',
        'budget_estime',
        'lieu_execution',
        'date_limite',
        'document_cctp',
        'statut',
        'vues'
    ];

    protected $casts = [
        'date_limite' => 'date',
    ];

    /**
     * L'entreprise qui a publié l'appel d'offre.
     */
    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }

    /**
     * Les propositions reçues pour cet appel d'offre.
     */
    public function propositions(): HasMany
    {
        return $this->hasMany(PropositionOffre::class);
    }
}
