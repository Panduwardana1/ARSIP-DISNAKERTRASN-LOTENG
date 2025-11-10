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
        Schema::create('agencies', function (Blueprint $t) {
            $t->id();
            $t->string('nama', 100)->index();
            $t->foreignId('perusahaan_id')->constrained('perusahaans')->cascadeOnDelete()->cascadeOnUpdate();
            $t->string('lowongan', 100)->nullable();
            $t->text('keterangan')->nullable();
            $t->timestamps();
            $t->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
