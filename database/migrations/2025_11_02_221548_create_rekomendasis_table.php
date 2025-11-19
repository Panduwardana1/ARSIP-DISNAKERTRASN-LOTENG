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
            $t->string('kode');
            $t->date('tanggal')->index();
            $t->unsignedInteger('total');
            $t->foreignId('author_id')
                ->constrained('authors')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
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
