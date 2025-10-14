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
        Schema::create('registrasi_tenaga_kerjas', function (Blueprint $t) {
            $t->id();
            $t->foreignId('tenaga_kerja_id')->constrained('tenaga_kerjas')->cascadeOnUpdate()->restrictOnDelete();
            $t->foreignId('agensi_lowongan_id')->constrained('agensi_lowongans')->cascadeOnUpdate()->restrictOnDelete();
            $t->foreignId('perusahaan_agensi_id')->constrained('perusahaan_agensis')->cascadeOnUpdate()->restrictOnDelete();

            // ! Snapshot dimensi (Saat daftar)
            $t->foreignId('perusahaan_id')->constrained('perusahaans')->cascadeOnUpdate()->restrictOnDelete();
            $t->foreignId('agensi_id')->constrained('agensis')->cascadeOnUpdate()->restrictOnDelete();
            $t->foreignId('lowongan_pekerjaan_id')->constrained('lowongan_pekerjaans')->cascadeOnUpdate()->restrictOnDelete();
            $t->foreignId('negara_id')->constrained('negaras')->cascadeOnUpdate()->restrictOnDelete();
            $t->foreignId('pendidikan_id')->constrained('pendidikans')->cascadeOnUpdate()->restrictOnDelete();

            $t->string('kecamatan', 100)->nullable();
            $t->string('desa', 100)->nullable();

            $t->enum('status', ['terdaftar', 'proses', 'berangkat', 'selesai', 'batal'])->default('terdaftar');
            $t->date('tanggal_daftar');
            $t->smallInteger('tahun');
            $t->tinyInteger('bulan');

            $t->timestamps();

            $t->unique(['tenaga_kerja_id', 'agensi_lowongan_id', 'tanggal_daftar'], 'uk_rtk_once_per_day');

            // index rekap umum
            $t->index(['tahun', 'bulan']);
            $t->index(['perusahaan_id', 'tahun', 'bulan']);
            $t->index(['agensi_id', 'tahun', 'bulan']);
            $t->index(['lowongan_pekerjaan_id', 'tahun', 'bulan'], 'ix_rtk_lowongan_bln');
            $t->index(['negara_id', 'tahun', 'bulan']);
            $t->index(['pendidikan_id', 'tahun', 'bulan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi_tenaga_kerjas');
    }
};
