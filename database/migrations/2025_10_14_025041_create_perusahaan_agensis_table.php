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
        Schema::create('perusahaan_agensis', function (Blueprint $t) {
            $t->id();
            $t->foreignId('perusahaan_id')->constrained('perusahaans')->cascadeOnUpdate()->restrictOnDelete();
            $t->foreignId('agensi_id')->constrained('agensis')->cascadeOnUpdate()->restrictOnDelete();
            $t->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $t->date('tanggal_mulai')->nullable();
            $t->date('tanggal_selesai')->nullable();
            $t->unique(['perusahaan_id', 'agensi_id'], 'uk_perusahaan_agensi');
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaan_agensis');
    }
};
