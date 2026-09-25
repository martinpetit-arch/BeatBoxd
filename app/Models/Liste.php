<?php

namespace App\Models;

use Database\Factories\ListeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Liste extends Model
{
    /** @use HasFactory<ListeFactory> */
    use HasFactory;

    protected $fillable = ['nom', 'description', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function albums(): BelongsToMany
    {
        return $this->belongsToMany(Album::class, 'album_liste')->withTimestamps();
    }
}
