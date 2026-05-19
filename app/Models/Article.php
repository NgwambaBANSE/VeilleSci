<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'slug',
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

    public function getResumeAttribute(?string $value): ?string
    {
        return $this->cleanTextValue($value);
    }

    public function getResumeIaAttribute(?string $value): ?string
    {
        return $this->cleanTextValue($value);
    }

    public function setResumeAttribute(?string $value): void
    {
        $this->attributes['resume'] = $this->cleanTextValue($value);
    }

    protected static function booted()
    {
        static::saving(function (self $article) {
            if ($article->isDirty('titre')) {
                $article->slug = $article->generateUniqueSlug($article->titre, $article->id ?? null);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function generateUniqueSlug(string $titre, ?int $ignoreId = null): string
    {
        $slug = Str::slug($titre) ?: 'article';
        $original = $slug;
        $counter = 1;

        while (DB::table('articles')
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }

    public function setResumeIaAttribute(?string $value): void
    {
        $this->attributes['resume_ia'] = $this->cleanTextValue($value);
    }

    protected function cleanTextValue(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        $clean = preg_replace('/<jats:[^>]+>/i', '', $value);
        $clean = preg_replace('/<\/jats:[^>]+>/i', '', $clean);
        $clean = strip_tags($clean);
        $clean = html_entity_decode($clean, ENT_QUOTES | ENT_XML1, 'UTF-8');
        $clean = preg_replace('/\s+/', ' ', $clean);
        $clean = trim($clean);

        return $clean === '' ? null : $clean;
    }

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
