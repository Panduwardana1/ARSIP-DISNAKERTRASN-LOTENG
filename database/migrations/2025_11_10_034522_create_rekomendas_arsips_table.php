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
        Schema::create('arsip_rekomendasis', function (Blueprint $t) {
            $t->id();
            $t->foreignId('rekomendasi_id')
                ->constrained('rekomendasis')
                ->cascadeOnDelete();
            $t->string('file_path');
            $t->dateTime('dicetak_pada');
            $t->foreignId('dicetak_oleh')
                ->constrained('users')
                ->cascadeOnDelete();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_rekomendasis');
    }
};
