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
            $table->foreignId('mahasiswa1')->constrained('users')->onDelete('cascade');
            $table->foreignId('mahasiswa2')->constrained('users')->onDelete('cascade');
            $table->foreignId('dospem1')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('dospem2')->nullable()->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('topik_bimbingan');
            $table->string('file');
            $table->text('review')->nullable();
            $table->string('status')->default('Menunggu');
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
