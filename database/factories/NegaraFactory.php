<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NegaraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $country = $this->faker->country();

        return [
            'nama' => "{$country} " . Str::upper(Str::random(3)),
            'kode_iso' => Str::upper(Str::random(3)),
        ];
    }
}
