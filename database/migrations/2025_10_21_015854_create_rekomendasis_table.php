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
        Schema::create('rekomendasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sequence');
            $table->string('nomor', 64)->unique();
            $table->unsignedSmallInteger('tahun');
            $table->date('tanggal_rekom');

            $table->foreignId('perusahaan_id')->nullable()->constrained('perusahaan_indonesias')->nullOnDelete();

            $table->unsignedInteger('jumlah_laki')->default(0);
            $table->unsignedInteger('jumlah_perempuan')->default(0);
            $table->unsignedInteger('total')->default(0);

            $table->foreignId('dibuat_oleh')->nullable()
                ->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->unique(['tahun', 'sequence']);
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
