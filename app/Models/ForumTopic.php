<?php
// ══════════════════════════════════════════════
// app/Models/ForumTopic.php
// ══════════════════════════════════════════════
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{
    protected $fillable = [
        'user_id', 'titre', 'contenu',
        'categorie', 'resolu', 'vues', 'epingle',
    ];

    protected $casts = [
        'resolu'  => 'boolean',
        'epingle' => 'boolean',
    ];

    public function user()    { return $this->belongsTo(User::class); }
    public function replies() { return $this->hasMany(ForumReply::class); }

    // Incrémenter les vues
    public function incrementVues(): void
    {
        $this->increment('vues');
    }
}
