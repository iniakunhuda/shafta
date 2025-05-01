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
        Schema::create('raport_nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_raport')->constrained('raport')->onDelete('cascade');
            $table->foreignId('id_pelajaran')->constrained('pelajaran')->onDelete('cascade');
            $table->float('nilai')->nullable();
            $table->string('nilai_huruf')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Create a unique constraint for the combination of raport and pelajaran
            $table->unique(['id_raport', 'id_pelajaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raport_nilai');
    }
};
