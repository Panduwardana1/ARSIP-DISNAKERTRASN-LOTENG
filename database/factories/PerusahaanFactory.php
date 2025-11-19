<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Perusahaan>
 */
class PerusahaanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama'     => $this->uniqueCompanyName(),
            'pimpinan' => $this->faker->name(),
            'email'    => $this->faker->unique()->safeEmail(),
            'alamat'   => $this->faker->address(),
            'gambar'   => null,
        ];
    }

    private function uniqueCompanyName(): string
    {
        $base = $this->faker->company();

        return "{$base} " . strtoupper(Str::random(4));
    }
}
