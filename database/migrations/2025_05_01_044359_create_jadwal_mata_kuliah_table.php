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
        Schema::create('jadwal_mata_kuliah', function (Blueprint $table) {
            $table->id();
            $table->string('hari', 20);
            $table->time('pukul');
            $table->string('kelas', 50);
            $table->string('ruang', 50);
            $table->string('kode', 20);
            $table->string('mata_kuliah', 100);
            $table->integer('sks');
            $table->foreignId('dosen_id')->constrained('dosen')->onDelete('restrict');
            $table->string('asisten_dosen', 100)->nullable();
            $table->string('mk_jurusan', 100);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_mata_kuliah');
    }
};
