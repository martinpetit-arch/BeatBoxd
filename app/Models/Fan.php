<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'artiste_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function artiste(): BelongsTo
    {
        return $this->belongsTo(Artiste::class);
    }
}