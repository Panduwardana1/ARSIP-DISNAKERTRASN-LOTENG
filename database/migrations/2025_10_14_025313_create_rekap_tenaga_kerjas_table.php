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
        Schema::create('rekap_tenaga_kerjas', function (Blueprint $t) {
            $t->id();
            $t->enum('jenis', ['bulanan', 'tahunan']);
            $t->date('periode');
            $t->smallInteger('tahun');
            $t->tinyInteger('bulan')->nullable();

            $t->foreignId('perusahaan_id')->nullable()->constrained('perusahaans')->nullOnDelete()->cascadeOnUpdate();
            $t->foreignId('agensi_id')->nullable()->constrained('agensis')->nullOnDelete()->cascadeOnUpdate();
            $t->foreignId('lowongan_pekerjaan_id')->nullable()->constrained('lowongan_pekerjaans')->nullOnDelete()->cascadeOnUpdate();
            $t->foreignId('negara_id')->nullable()->constrained('negaras')->nullOnDelete()->cascadeOnUpdate();
            $t->foreignId('pendidikan_id')->nullable()->constrained('pendidikans')->nullOnDelete()->cascadeOnUpdate();

            $t->string('kecamatan', 100)->nullable();
            $t->string('desa', 100)->nullable();

            $t->unsignedInteger('total')->default(0);
            $t->timestamps();

            $t->unique([
                'jenis',
                'tahun',
                'bulan',
                'perusahaan_id',
                'agensi_id',
                'lowongan_pekerjaan_id',
                'negara_id',
                'pendidikan_id',
                'kecamatan',
                'desa'
            ], 'uk_rekap_combo');
            $t->index(['jenis', 'tahun', 'bulan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_tenaga_kerjas');
    }
};
