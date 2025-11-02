<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PendidikanSeeder;
use Database\Seeders\PerusahaanSeeder;
use Database\Seeders\WilayahSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            WilayahSeeder::class,
            PerusahaanSeeder::class,
            PendidikanSeeder::class,
        ]);
    }
}
