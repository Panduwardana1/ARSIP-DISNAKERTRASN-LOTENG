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
                ->cascadeOnDelete()
                ->cascadeOnUpdate();;
            $t->string('kode_pos', 10)->nullable();
            $t->foreignId('pendidikan_id')
                ->constrained('pendidikans')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();;
            $t->foreignId('perusahaan_id')
                ->constrained('perusahaans')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $t->foreignId('agency_id')
                ->constrained('agencies')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $t->foreignId('negara_id')
                ->constrained('negaras')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

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
