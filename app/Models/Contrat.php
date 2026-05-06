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
    ];

    protected $casts = [
        'avantages' => 'array',
        'date_debut' => 'date',
        'date_fin' => 'date',
        'signed_at_employer' => 'datetime',
        'signed_at_employee' => 'datetime',
        'sent_at' => 'datetime',
    ];

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
