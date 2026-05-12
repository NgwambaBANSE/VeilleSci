<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunite extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'categorie',
        'domaine',
        'date_limite',
        'pays',
        'description',
        'lien',
        'active',
    ];

    protected $casts = [
        'date_limite' => 'date',
        'active'      => 'boolean',
    ];
}