<?php

namespace Database\Factories;

use App\Models\Pendidikan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pendidikan>
 */
class PendidikanFactory extends Factory
{
    protected $model = Pendidikan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');
        $level = $faker->randomElement(['SD', 'SMP', 'SMA', 'SMK', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3', 'PROFESI']);

        return [
            // tambah 0-2 angka agar nilai unik dan tetap di bawah 10 karakter
            'nama' => $faker->unique()->regexify($level . '[0-9]{0,2}'),
        ];
    }
}
