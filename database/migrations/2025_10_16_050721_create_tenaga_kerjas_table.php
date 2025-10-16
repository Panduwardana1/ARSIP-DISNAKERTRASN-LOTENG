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
        Schema::create('tenaga_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->char('nik', 16)->unique();
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('email', 100)->nullable();
            $table->string('desa', 100);
            $table->string('kecamatan', 100);
            $table->text('alamat_lengkap');
            $table->foreignId('pendidikan_id')->constrained('pendidikans')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('lowongan_id')->constrained('lowongans')->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
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
