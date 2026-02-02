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
        Schema::create('statistike', function (Blueprint $table) {
            $table->id();
            $table->foreignId('korisnik_id') ->constrained('users')->cascadeOnDelete();
            $table->integer('broj_odradjenih_zadataka')->default(0);
            $table->integer('ukupan_broj_zadataka')->default(0);
            $table->decimal('procenat_uspesnosti', 5, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistike');
    }
};
