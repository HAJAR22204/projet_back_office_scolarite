<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'message',
        'date_envoi',
        'lu',
    ];

    protected $casts = [
        'date_envoi' => 'datetime',
        'lu' => 'boolean',
    ];

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
