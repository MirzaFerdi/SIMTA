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
        Schema::create('sempros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengusul1')->constrained('users')->onDelete('cascade');
            $table->foreignId('pengusul2')->constrained('users')->onDelete('cascade');
            $table->foreignId('dospem_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pengajuan_id')->constrained('pengajuan_juduls')->onDelete('cascade');
            $table->string('no_ta');
            $table->string('abstrak');
            $table->string('status')->default('Menunggu');
            $table->string('laporan');
            $table->string('ppt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sempros');
    }
};
