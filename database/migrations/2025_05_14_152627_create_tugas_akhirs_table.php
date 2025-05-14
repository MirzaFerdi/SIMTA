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
        Schema::create('tugas_akhirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengusul1')->constrained('users')->onDelete('cascade');
            $table->foreignId('pengusul2')->constrained('users')->onDelete('cascade');
            $table->foreignId('pengajuan_id')->constrained('pengajuan_juduls')->onDelete('cascade');
            $table->integer('no_ta');
            $table->string('abstrak');
            $table->string('status')->default('diproses');
            $table->string('laporan');
            $table->string('ppt');
            $table->string('berita_acara');
            $table->string('bimbingan');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_akhirs');
    }
};
