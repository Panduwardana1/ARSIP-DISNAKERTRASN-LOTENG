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
            $t->string('nama_perusahaan', 150);
            $t->string('email', 120)->nullable();
            $t->string('nama_pimpinan', 120)->nullable();
            $t->string('no_telepon', 20)->nullable();
            $t->text('alamat')->nullable();
            $t->timestamps();
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
