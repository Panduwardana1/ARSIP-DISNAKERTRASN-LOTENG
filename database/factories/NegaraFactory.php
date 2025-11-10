<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\Negara>
 */
class NegaraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->unique()->country(),
            'kode_iso' => $this->faker->unique()->countryISOAlpha3(),
            'is_active' => $this->faker->randomElement(['Aktif', 'Banned']),
        ];
    }
}
