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
            $t->string('nama');
            $t->char('nik', 16)->unique();
            $t->enum('gender', ['L', 'P']);
            $t->string('email', 100)->nullable();
            $t->string('tempat_lahir', 150);
            $t->date('tanggal_lahir');
            $t->text('alamat_lengkap');
            $t->foreignId('kecamatan_id')
                ->constrained('kecamatans')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $t->foreignId('desa_id')
                ->constrained('desas')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
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
