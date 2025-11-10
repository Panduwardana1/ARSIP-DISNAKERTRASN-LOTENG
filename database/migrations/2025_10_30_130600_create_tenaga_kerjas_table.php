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
        Schema::create('tenaga_kerjas', function (Blueprint $t) {
            $t->id();
            $t->string('nama')->index();
            $t->char('nik', 16)->unique()->index();
            $t->enum('gender', ['L', 'P']);
            $t->string('email', 100)->nullable()->unique();
            $t->string('no_telpon', 20)->nullable();
            $t->string('tempat_lahir', 100);
            $t->date('tanggal_lahir');
            $t->text('alamat_lengkap');
            $t->foreignId('desa_id')
            ->constrained('desas')
            ->cascadeOnUpdate()
            ->restrictOnDelete();
            $t->string('kode_pos', 10)->nullable();
            $t->foreignId('pendidikan_id')
                ->constrained('pendidikans')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $t->foreignId('perusahaan_id')
                ->constrained('perusahaans')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $t->foreignId('agency_id')
                ->constrained('agencies')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $t->foreignId('negara_id')
                ->constrained('negaras')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $t->enum('is_active', ['Aktif', 'Banned'])->default('Aktif');

            $t->timestamps();
            $t->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenaga_kerjas');
    }
};
