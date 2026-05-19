<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
    'cne',
    'code_apogee',
    'nom',
    'prenom',
    'email',
    'traite_par',
    'date_creation',
    'statut',
    'date_traitement',
    'type_document',
    'semestre',
    'type_retrait',
    'commentaire',
    'motif_refus',
];

    protected $casts = [
        'date_creation' => 'datetime',
        'date_traitement' => 'datetime',
        'semestre' => 'integer',
        'type_retrait' => 'string',
    ];

    public function traitePar()
    {
        return $this->belongsTo(User::class, 'traite_par');
    }

    public function document()
    {
        return $this->hasOne(DocumentDemande::class);
    }
}