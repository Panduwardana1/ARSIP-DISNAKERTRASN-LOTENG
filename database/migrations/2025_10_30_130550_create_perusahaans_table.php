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
        Schema::create('perusahaans', function (Blueprint $t) {
            $t->id();
            $t->string('nama', 100);
            $t->string('pimpinan', 100)->nullable();
            $t->string('email', 100)->unique();
            $t->text('alamat')->nullable();
            $t->string('gambar');
            $t->foreignId('agency_id')->constrained('agencies')->cascadeOnUpdate();
            $t->timestamps();
            $t->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaans');
    }
};
