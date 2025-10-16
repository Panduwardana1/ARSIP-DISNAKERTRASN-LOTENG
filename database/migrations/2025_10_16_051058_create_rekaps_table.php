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
        Schema::create('rekaps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenaga_kerja_id')->constrained('tenaga_kerjas')->cascadeOnDelete();
            $table->foreignId('lowongan_id')->constrained('lowongans')->cascadeOnDelete();
            $table->foreignId('destinasi_id')->nullable()->constrained('destinasis')->nullOnDelete();
            $table->enum('status', ['daftar', 'verifikasi', 'penempatan', 'batal'])->default('daftar')->index();

            $table->unique(['tenaga_kerja_id', 'lowongan_id']);
            $table->index(['lowongan_id', 'status']);
            $table->foreignId('dibuat_oleh')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekaps');
    }
};
