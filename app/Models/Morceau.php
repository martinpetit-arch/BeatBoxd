<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Morceau extends Model
{
    use HasFactory;

    protected $table = 'morceaux';

    protected $fillable = ['titre', 'numero', 'duree', 'album_id'];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    // Transforme les secondes en format "3:45"
    public function getDureeFormateeAttribute()
    {
        if (!$this->duree) {
            return null;
        }

        $minutes = intdiv($this->duree, 60);
        $secondes = $this->duree % 60;

        return $minutes . ':' . str_pad($secondes, 2, '0', STR_PAD_LEFT);
    }
}