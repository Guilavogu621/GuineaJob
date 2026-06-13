<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class OffreEmploi extends Model
{
    use HasFactory;

    protected $table = 'offres_emploi';

    // Statuts de l'offre d'emploi
    const STATUS_DRAFT = 'brouillon';
    const STATUS_PUBLISHED = 'publiee';
    const STATUS_ARCHIVED = 'archivee';
    const STATUS_CLOSED = 'cloturee';

    protected $fillable = [
        'entreprise_id',
        'titre',
        'description',
        'competences_requises',
        'lieu',
        'type_contrat',
        'salaire_range',
        'date_expiration',
        'statut',
        'vues'
    ];

    /**
     * Interagit avec l'attribut titre pour l'auto-capitaliser (ucwords).
     */
    protected function titre(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucwords(strtolower($value)),
        );
    }

    /**
     * L'entreprise qui a publié l'offre.
     */
    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }

    /**
     * Les candidatures reçues pour cette offre.
     */
    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class, 'offre_emploi_id');
    }
}
