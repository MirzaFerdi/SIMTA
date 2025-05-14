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
        Schema::create('bimbingans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengusul1')->constrained('users')->onDelete('cascade');
            $table->foreignId('pengusul2')->constrained('users')->onDelete('cascade');
            $table->foreignId('dospem')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('topik_bimbingan');
            $table->string('status')->default('diproses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bimbingans');
    }
};
