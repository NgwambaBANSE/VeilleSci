<?php
// ── app/Models/ForumSujet.php ──────────────────────────────
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumSujet extends Model
{
    protected $fillable = [
        'user_id', 'titre', 'contenu',
        'categorie', 'resolu', 'vues', 'epingle',
    ];

    protected $casts = [
        'resolu'  => 'boolean',
        'epingle' => 'boolean',
    ];

    public function user()     { return $this->belongsTo(User::class); }
    public function reponses() { return $this->hasMany(ForumReponse::class, 'sujet_id'); }

    // Incrémenter les vues
    public function incrementerVues(): void
    {
        $this->increment('vues');
    }
}

