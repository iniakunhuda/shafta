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
        Schema::table('raport', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published', 'archived'])
                ->default('draft')
                ->comment('Status of the raport: draft, published, or archived');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('raport', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
