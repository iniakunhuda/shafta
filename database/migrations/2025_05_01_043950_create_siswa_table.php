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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique();
            $table->string('nisn')->nullable()->unique();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['l', 'p']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('ayah_nama')->nullable();
            $table->text('ayah_alamat')->nullable();
            $table->string('ayah_pekerjaan')->nullable();
            $table->string('ayah_telp')->nullable();
            $table->string('ibu_nama')->nullable();
            $table->text('ibu_alamat')->nullable();
            $table->string('ibu_pekerjaan')->nullable();
            $table->enum('status', ['active', 'pending', 'block'])->default('pending');
            $table->foreignId('id_user')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
