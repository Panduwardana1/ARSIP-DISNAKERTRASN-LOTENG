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
            $t->foreignId('rekomendasi_id')
                ->constrained('rekomendasis')
                ->cascadeOnDelete()
                ->index('rekomendasi_items_rekomendasi_index');
            $t->foreignId('tenaga_kerja_id')
                ->constrained('tenaga_kerjas')
                ->cascadeOnDelete()
                ->index('rekomendasi_items_tenaga_kerja_index');

            $t->unique(['rekomendasi_id', 'tenaga_kerja_id'], 'rekomendasi_items_unique');
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
