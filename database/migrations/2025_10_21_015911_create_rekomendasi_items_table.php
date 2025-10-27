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
        Schema::create('rekomendasi_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekomendasi_id')
                ->constrained('rekomendasis')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('tenaga_kerja_id')
                ->constrained('tenaga_kerjas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // snapshot ID
            $table->foreignId('lowongan_id')
                ->constrained('lowongans')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('agensi_id')
                ->constrained('agensi_penempatans')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('perusahaan_id')
                ->constrained('perusahaan_indonesias')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('destinasi_id')
                ->constrained('destinasis')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('pendidikan_id')
                ->constrained('pendidikans')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // snapshot teks
            $table->string('nik', 16);
            $table->string('nama');
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->timestamps();

            $table->unique(['rekomendasi_id', 'tenaga_kerja_id']);
            $table->index('nik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_items');
    }
};
