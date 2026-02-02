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
        Schema::create('beleska', function (Blueprint $table) {
            $table->id();
            $table->foreignId('korisnik_id') ->constrained('users')->cascadeOnDelete();
            $table->string('naslov');
            $table->text('sadrzaj');
            $table->timestamp('kreirano')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beleska');
    }
};
