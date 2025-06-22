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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengusul1')->constrained('users')->onDelete('cascade');
            $table->foreignId('pengusul2')->constrained('users')->onDelete('cascade');
            $table->foreignId('pengajuan_id')->constrained('pengajuan_juduls')->onDelete('cascade');
            $table->foreignId('dospem1')->constrained('users')->onDelete('cascade');
            $table->foreignId('dospem2')->constrained('users')->onDelete('cascade');
            $table->foreignId('dosen_penguji1')->constrained('users')->onDelete('cascade');
            $table->foreignId('dosen_penguji2')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('tahun_akademik');
            $table->time('jam');
            $table->string('tempat');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
