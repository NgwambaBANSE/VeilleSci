<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'auteurs',
        'domaine',
        'categorie',
        'doi',
        'url',
        'date_publication',
        'journal',
        'resume',
        'resume_ia',
        'mots_cles',
        'source',
        'active',
    ];

    protected $casts = [
        'date_publication' => 'date',
        'active'           => 'boolean',
    ];

    /**
     * Relation avec les favoris
     */
    public function favoris()
    {
        return $this->hasMany(Favori::class, 'article_id');
    }

    /**
     * Vérifier si cet article est favori pour un utilisateur
     */
    public function isFavoriBy($userId)
    {
        return $this->favoris()
            ->where('user_id', $userId)
            ->where('type', 'article')
            ->exists();
    }
}
