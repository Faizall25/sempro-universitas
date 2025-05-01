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
        Schema::create('pengajuan_sempro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->text('judul');
            $table->text('abstrak');
            $table->string('jurusan', 100);
            $table->string('fakultas', 100);
            $table->foreignId('bidang_keilmuan_id')->constrained('bidang_keilmuan')->onDelete('restrict');
            $table->foreignId('dosen_pembimbing_id')->constrained('dosen')->onDelete('restrict');
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_sempro');
    }
};
