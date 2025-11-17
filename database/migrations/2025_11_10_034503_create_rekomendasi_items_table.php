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
        Schema::create('rekomendasi_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('rekomendasi_id')->constrained()->cascadeOnDelete();
            $t->foreignId('tenaga_kerja_id')->constrained('tenaga_kerjas')->cascadeOnDelete();
            $t->foreignId('perusahaan_id')->constrained('perusahaans')->cascadeOnDelete();
            $t->foreignId('negara_id')->constrained('negaras')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_items');
    }
};
