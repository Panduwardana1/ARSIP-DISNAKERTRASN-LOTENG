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
        Schema::create('agensi_lowongans', function (Blueprint $t) {
            $t->id();
            $t->foreignId('lowongan_pekerjaan_id')->constrained('lowongan_pekerjaans')->cascadeOnUpdate()->restrictOnDelete();
            $t->foreignId('negara_id')->constrained('negaras')->cascadeOnUpdate()->restrictOnDelete();
            $t->foreignId('perusahaan_agensi_id')->constrained('perusahaan_agensis')->cascadeOnUpdate()->restrictOnDelete();
            $t->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $t->date('tanggal_mulai');
            $t->timestamps();

            $t->unique(['lowongan_pekerjaan_id', 'negara_id', 'perusahaan_agensi_id'], 'uk_alw_lowongan_negara_perusahaan');
            $t->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agensi_lowongans');
    }
};
