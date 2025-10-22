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
        Schema::create('lowongans', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->foreignId('agensi_id')->constrained('agensi_penempatans')->cascadeOnDelete();
            $table->foreignId('perusahaan_id')->constrained('perusahaan_indonesias')->cascadeOnDelete();
            $table->foreignId('destinasi_id')->constrained('destinasis')->cascadeOnDelete();
            $table->enum('is_aktif', ['aktif', 'non_aktif'])->default('aktif');
            $table->string('catatan')->nullable();
            $table->unique(['agensi_id', 'perusahaan_id']);
            $table->timestamps();
            $table->index(['agensi_id', 'perusahaan_id', 'destinasi_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }
};
