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
        Schema::create('berita_acaras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengusul1')->constrained('users')->onDelete('cascade');
            $table->foreignId('pengusul2')->constrained('users')->onDelete('cascade');
            $table->foreignId('dosen')->constrained('users')->onDelete('cascade');
            $table->foreignId('pengajuan_id')->constrained('pengajuan_juduls')->onDelete('cascade');
            $table->string('berita_acara');
            $table->string('status')->default('Telah Diseminarkan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita_acaras');
    }
};
