<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Seeder;
use App\Models\Perusahaan;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agencies = Agency::factory()->count(50)->create();

        Perusahaan::factory()->count(334)
        ->state(fn() => ['agency_id' => $agencies->random()->id])
        ->create();
    }
}
