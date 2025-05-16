<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalSemproApprovalsTable extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_sempro_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_sempro_id')->constrained('jadwal_sempro')->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('dosen')->onDelete('restrict');
            $table->enum('status', ['pending', 'setuju', 'tolak'])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_sempro_approvals');
    }
}
