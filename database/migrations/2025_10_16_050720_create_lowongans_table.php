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
            $table->string('nama', 100);
            $table->foreignId('agensi_id')->constrained('agensi_penempatans')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('perusahaan_id')->constrained('perusahaan_indonesias')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedSmallInteger('kontrak_kerja')->unique();
            $table->foreignId('destinasis_id')->constrained('destinasis')->cascadeOnDelete()->cascadeOnDelete();
            $table->enum('is_aktif', ['aktif', 'non_aktif'])->default('aktif');
            $table->timestamps();
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
