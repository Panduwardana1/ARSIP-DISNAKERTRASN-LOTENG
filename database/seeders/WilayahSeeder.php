<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Kecamatan;
use App\Models\Perusahaan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatans = Kecamatan::factory()->count(12)->create();

        Desa::factory()
            ->count(137)
            ->state(fn() => ['kecamatan_id' => $kecamatans->random()->id])
            ->create();
    }
}
