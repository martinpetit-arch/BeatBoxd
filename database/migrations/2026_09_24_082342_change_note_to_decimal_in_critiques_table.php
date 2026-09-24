<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('critiques', function (Blueprint $table) {
            $table->decimal('note', 2, 1)->change();
        });
    }

    public function down(): void
    {
        Schema::table('critiques', function (Blueprint $table) {
            $table->integer('note')->change();
        });
    }
};