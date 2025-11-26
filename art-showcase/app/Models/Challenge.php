<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'curator_id',
        'start_date',
        'end_date',
        'winner_artwork_id',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function curator()
    {
        return $this->belongsTo(User::class, 'curator_id');
    }

    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }

    public function winner()
    {
        return $this->belongsTo(Artwork::class, 'winner_artwork_id');
    }

    public function isActive()
    {
        $now = now();
        return $this->status === 'active' 
            && $now->gte($this->start_date) 
            && $now->lte($this->end_date);
    }

    public function isClosed()
    {
        return $this->status === 'closed' || now()->gt($this->end_date);
    }
}

