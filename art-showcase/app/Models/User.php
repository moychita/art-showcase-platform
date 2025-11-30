<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_MEMBER = 'member';
    const ROLE_CURATOR = 'curator';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'bio',
        'external_links',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'external_links' => 'array',
    ];

    // --- HELPER METHODS ---
    
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isMember()
    {
        return $this->role === self::ROLE_MEMBER;
    }

    public function isCurator()
    {
        return $this->role === self::ROLE_CURATOR;
    }

    public function isPendingCurator()
    {
        return $this->role === self::ROLE_CURATOR && $this->status === 'pending';
    }

    // --- RELATIONSHIPS (HUBUNGAN DATABASE) ---

    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // PENTING: Ini yang menghubungkan Curator ke Challenge buatannya
    public function challenges()
    {
        return $this->hasMany(Challenge::class, 'curator_id');
    }
}