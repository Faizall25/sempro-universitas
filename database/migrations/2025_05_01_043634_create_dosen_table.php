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
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nip', 30)->unique();
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->string('asal_kota', 100);
            $table->foreignId('bidang_keilmuan_id')->constrained('bidang_keilmuan')->onDelete('restrict');
            $table->enum('peran', ['biasa', 'pembimbing', 'penguji'])->default('biasa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
