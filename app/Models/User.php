<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'is_admin', 'google_id', 'google_token', 'avatar'])]
#[Hidden(['password', 'remember_token', 'google_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get the user's favorite opportunities.
     */
    public function favoris()
    {
        return $this->hasMany(Favori::class);
    }

    public function profile()
    {
        return $this->hasOne(\App\Models\Profile::class);
    }
    // ══════════════════════════════════════════════
// À ajouter dans app/Models/User.php
// ══════════════════════════════════════════════
public function forumTopics() { return $this->hasMany(ForumTopic::class); }
public function forumReplies() { return $this->hasMany(ForumReply::class); }
}
