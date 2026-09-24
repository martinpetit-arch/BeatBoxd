<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('morceaus', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->integer('numero'); // position dans la tracklist (1, 2, 3...)
            $table->integer('duree'); // durée en secondes
            $table->foreignId('album_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('morceaus');
    }
};