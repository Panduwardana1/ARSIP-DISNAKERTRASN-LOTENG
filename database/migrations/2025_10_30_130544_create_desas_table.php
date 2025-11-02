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
        Schema::create('desas', function (Blueprint $t) {
            $t->id();
            $t->foreignId('kecamatan_id')
                ->constrained('kecamatans')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $t->string('nama', 100);
            $t->enum('tipe', ['desa', 'kelurahan']);
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desas');
    }
};
