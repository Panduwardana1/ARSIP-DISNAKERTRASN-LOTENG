<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PendidikanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $label = fake()->unique()->words(2, true);

        return [
            'nama' => Str::upper(Str::replace(' ', '_', Str::limit($label, 10, ''))),
            'label' => Str::headline($label),
        ];
    }
}
