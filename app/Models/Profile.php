<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'titre', 'institution', 'departement',
        'specialite', 'pays', 'ville', 'telephone',
        'biographie', 'photo', 'cv',
        'orcid', 'researchgate', 'linkedin', 'site_web',
        'publications',
    ];

    protected $casts = [
        'publications' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

// ── À ajouter dans app/Models/User.php ───────────────────
// public function profile()
// {
//     return $this->hasOne(Profile::class);
// }
//
// public function getProfileAttribute()
// {
//     return $this->relations['profile'] ?? $this->getRelationValue('profile');
// }