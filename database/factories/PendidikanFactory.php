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
        $labelBase = fake()->words(2, true);
        $suffix = strtoupper(Str::random(2));
        $slug = strtoupper(Str::slug($labelBase, '_'));
        $slug = substr($slug, 0, max(1, 10 - (strlen($suffix) + 1)));
        if ($slug === '') {
            $slug = strtoupper(Str::random(3));
        }

        return [
            'nama' => rtrim($slug, '_') . '_' . $suffix,
            'label' => Str::headline($labelBase) . " {$suffix}",
        ];
    }
}
