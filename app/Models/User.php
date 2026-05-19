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
            'google_id' => 'encrypted',      // Chiffrer les données OAuth
            'google_token' => 'encrypted',   // Chiffrer les tokens sensibles
            'avatar' => 'encrypted',         // Chiffrer les URLs d'avatar
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
    // Forum Relations
    // ══════════════════════════════════════════════
    public function forumTopics()
    {
        return $this->hasMany(ForumTopic::class);
    }

    public function forumReplies()
    {
        return $this->hasMany(ForumReply::class);
    }

    // ══════════════════════════════════════════════
    // Admin Management Methods
    // ══════════════════════════════════════════════

    /**
     * Vérifier si l'utilisateur est administrateur
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    /**
     * Vérifier si l'utilisateur peut gérer les administrateurs
     * (doit être administrateur)
     */
    public function canManageAdmins(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Promouvoir l'utilisateur en administrateur
     */
    public function promoteToAdmin(): bool
    {
        if ($this->isAdmin()) {
            return false;
        }

        return $this->update(['is_admin' => true]);
    }

    /**
     * Retirer les droits d'administrateur
     */
    public function demoteFromAdmin(): bool
    {
        if (!$this->isAdmin()) {
            return false;
        }

        return $this->update(['is_admin' => false]);
    }

    /**
     * Obtenir la liste des administrateurs
     */
    public static function admins()
    {
        return static::where('is_admin', true);
    }

    /**
     * Obtenir la liste des utilisateurs normaux
     */
    public static function regularUsers()
    {
        return static::where('is_admin', false);
    }
}

