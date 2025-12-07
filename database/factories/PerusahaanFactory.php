<?php

namespace Database\Factories;

use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Perusahaan>
 */
class PerusahaanFactory extends Factory
{
    protected $model = Perusahaan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');

        return [
            'nama' => $faker->unique()->company(),
            'pimpinan' => $faker->name(),
            'email' => $faker->unique()->companyEmail(),
            'alamat' => $faker->address(),
            'gambar' => 'images/perusahaan/default.png',
        ];
    }
}
