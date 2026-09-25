<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('album_liste', function (Blueprint $table) {
            $table->foreignId('liste_id')->constrained('listes')->onDelete('cascade');
            $table->foreignId('album_id')->constrained()->onDelete('cascade');
            $table->primary(['liste_id', 'album_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_liste');
    }
};
