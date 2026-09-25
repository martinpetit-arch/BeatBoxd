<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artiste extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'photo'];

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    public function fans(): HasMany
    {
        return $this->hasMany(Fan::class);
    }

    public function estFanPar($userId): bool
    {
        return $this->fans()->where('user_id', $userId)->exists();
    }
}
