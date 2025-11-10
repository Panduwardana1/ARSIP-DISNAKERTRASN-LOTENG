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
        Schema::create('rekomendasis', function (Blueprint $t) {
            $t->id();
            $t->string('kode')->unique();
            $t->date('tanggal')->index('rekomendasis_tanggal_index');
            $t->unsignedInteger('total');
            $t->foreignId('author_id')
                ->constrained('authors')
                ->cascadeOnDelete()
                ->index('rekomendasis_author_id_index');
            $t->foreignId('user_verifikasi_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->index('rekomendasis_verifikator_id_index');

            $t->softDeletes();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasis');
    }
};
