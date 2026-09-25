<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'pochette', 'annee', 'description', 'artiste_id'];

    public function artiste(): BelongsTo
    {
        return $this->belongsTo(Artiste::class);
    }

    public function morceaux(): HasMany
    {
        return $this->hasMany(Morceau::class)->orderBy('numero');
    }

    public function critiques(): HasMany
    {
        return $this->hasMany(Critique::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function estLikePar($userId): bool
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function getNoteMoyenneAttribute(): ?float
    {
        $moyenne = $this->critiques->avg('note');

        return $moyenne === null ? null : round((float) $moyenne, 1);
    }
}
