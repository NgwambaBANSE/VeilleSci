<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// ══════════════════════════════════════════════
// app/Models/ForumReply.php
// ══════════════════════════════════════════════
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    protected $fillable = [
        'user_id', 'forum_topic_id',
        'contenu', 'meilleure_reponse', 'votes',
    ];

    protected $casts = [
        'meilleure_reponse' => 'boolean',
    ];

    public function user()  { return $this->belongsTo(User::class); }
    public function topic() { return $this->belongsTo(ForumTopic::class); }
}
