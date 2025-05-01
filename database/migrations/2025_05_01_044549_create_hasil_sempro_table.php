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
        Schema::create('hasil_sempro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_sempro_id')->constrained('jadwal_sempro')->onDelete('cascade');
            $table->float('nilai_peng1');
            $table->float('nilai_peng2');
            $table->float('nilai_peng3');
            $table->float('rata_rata');
            $table->enum('status', ['lolos_tanpa_revisi', 'revisi_minor', 'revisi_mayor', 'tidak_lolos']);
            $table->string('revisi_file_path', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_sempro');
    }
};
