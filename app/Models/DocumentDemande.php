<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentDemande extends Model
{
    use HasFactory;

    protected $fillable = [
        'demande_id',
        'nom',
        'chemin_fichier',
        'date_generation',
    ];

    protected $casts = [
        'date_generation' => 'datetime',
    ];

    public function demande()
    {
        return $this->belongsTo(Demande::class);
    }
}
