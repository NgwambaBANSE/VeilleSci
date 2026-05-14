<?php
// ── app/Models/ForumSujet.php ──────────────────────────────
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// ── app/Models/ForumReponse.php ────────────────────────────
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumReponse extends Model
{
    protected $fillable = [
        'sujet_id', 'user_id', 'contenu', 'meilleure_reponse',
    ];

    protected $casts = ['meilleure_reponse' => 'boolean'];

    public function user()  { return $this->belongsTo(User::class); }
    public function sujet() { return $this->belongsTo(ForumSujet::class, 'sujet_id'); }
}