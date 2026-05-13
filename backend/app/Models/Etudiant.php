<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'cne',
        'code_apogee',
        'nom',
        'prenom',
    ];

    public function demandes()
    {
        return $this->hasMany(Demande::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
