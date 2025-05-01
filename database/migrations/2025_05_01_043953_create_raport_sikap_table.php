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
        Schema::create('raport_sikap', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_raport')->constrained('raport')->onDelete('cascade');
            $table->foreignId('id_sikap')->constrained('sikap')->onDelete('cascade');
            $table->string('sikap_judul');
            $table->text('sikap_deskripsi')->nullable();
            $table->float('bobot')->default(1);
            $table->integer('jumlah')->default(0);
            $table->float('nilai')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();

            // Create a unique constraint for the combination of raport and sikap
            $table->unique(['id_raport', 'id_sikap']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raport_sikap');
    }
};
