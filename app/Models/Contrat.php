<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    // Définition des statuts du workflow
    const STATUS_DRAFT = 'Brouillon';
    const STATUS_SENT = 'Envoyé';
    const STATUS_SIGNED_EMPLOYER = 'Signé employeur';
    const STATUS_SIGNED_EMPLOYEE = 'Signé employé';
    const STATUS_ACTIVE = 'Actif';
    const STATUS_CANCELLED = 'Annulé';

    // Types de résiliation légaux
    const RUPTURE_DEMISSION = 'Démission';
    const RUPTURE_LICENCIEMENT = 'Licenciement';
    const RUPTURE_ACCORD = 'Commun accord';
    const RUPTURE_FIN_CDD = 'Fin de contrat';
    const RUPTURE_FAUTE_GRAVE = 'Faute grave';
    const RUPTURE_STAGE_ABANDON = 'Abandon de stage';
    const RUPTURE_STAGE_EMBAUCHE = 'Embauche après stage';

    protected $fillable = [
        'employe_id',
        'entreprise_id',
        'numero_contrat',
        'type_contrat',
        'date_debut',
        'date_fin',
        'periode_essai',
        'salaire_mensuel_brut',
        'clauses_specifiques',
        'avantages',
        'statut',
        'document_path',
        'signed_at_employer',
        'ip_employer',
        'signed_at_employee',
        'ip_employee',
        'sent_at',
        'type_resiliation',
        'motif_resiliation',
        'date_resiliation',
        'resilie_at',
    ];

    protected $casts = [
        'avantages' => 'array',
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_resiliation' => 'date',
        'signed_at_employer' => 'datetime',
        'signed_at_employee' => 'datetime',
        'sent_at' => 'datetime',
        'resilie_at' => 'datetime',
    ];

    /**
     * Logique automatique à la création
     */
    protected static function booted()
    {
        static::creating(function ($contrat) {
            if (!$contrat->numero_contrat) {
                $contrat->numero_contrat = 'CTR-' . date('Y') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
            }
        });
    }

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    // Helpers pour vérifier le statut
    public function isDraft() { return $this->statut === self::STATUS_DRAFT; }
    public function isSent() { return $this->statut === self::STATUS_SENT; }
    public function isSignedByEmployer() { return in_array($this->statut, [self::STATUS_SIGNED_EMPLOYER, self::STATUS_SIGNED_EMPLOYEE, self::STATUS_ACTIVE]); }
    public function isSignedByEmployee() { return in_array($this->statut, [self::STATUS_SIGNED_EMPLOYEE, self::STATUS_ACTIVE]); }
}
