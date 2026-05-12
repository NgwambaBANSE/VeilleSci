<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favori extends Model
{
    protected $fillable = ['user_id', 'opportunite_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function opportunite(): BelongsTo
    {
        return $this->belongsTo(Opportunite::class);
    }
}
