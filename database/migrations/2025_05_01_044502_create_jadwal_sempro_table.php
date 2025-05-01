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
        Schema::create('jadwal_sempro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_sempro_id')->constrained('pengajuan_sempro')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('ruang', 50);
            $table->foreignId('dosen_penguji_1')->constrained('dosen')->onDelete('restrict');
            $table->foreignId('dosen_penguji_2')->constrained('dosen')->onDelete('restrict');
            $table->foreignId('dosen_penguji_3')->constrained('dosen')->onDelete('restrict');
            $table->enum('status', ['dijadwalkan', 'selesai'])->default('dijadwalkan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_sempro');
    }
};
