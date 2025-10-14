<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $t->string('nomor_induk', 16)->unique();
            $t->enum('jenis_kelamin', ['L', 'P']);
            $t->string('tempat_lahir', 150)->nullable();
            $t->date('tanggal_lahir')->nullable();
            $t->string('email', 150)->nullable();
            $t->string('desa', 100)->nullable();
            $t->string('kecamatan', 100)->nullable();
            $t->text('alamat_lengkap');

            $t->foreignId('pendidikan_id')->nullable()->constrained('pendidikans')->cascadeOnUpdate()->nullOnDelete();

            $t->foreignId('agensi_lowongan_id')->nullable()->constrained('agensi_lowongans')->cascadeOnUpdate()->nullOnDelete();

            $t->timestamps();

            $t->index(['kecamatan', 'desa']);
        });

        // ! Cek panjang nomor induk 16
        DB::statement("ALTER TABLE tenaga_kerjas ADD CONSTRAINT chk_nomor_induk_len CHECK (char_length(nomor_induk) = 16)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenaga_kerjas');
    }
};
