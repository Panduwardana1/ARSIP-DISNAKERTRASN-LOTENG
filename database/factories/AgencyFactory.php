<?php

namespace Database\Factories;

use App\Models\Agency;
use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Agency>
 */
class AgencyFactory extends Factory
{
    protected $model = Agency::class;

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
            'perusahaan_id' => Perusahaan::factory(),
            'lowongan' => $faker->jobTitle(),
            'keterangan' => $faker->sentence(),
        ];
    }
}
