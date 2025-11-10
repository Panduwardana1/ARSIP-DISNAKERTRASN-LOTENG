<?php

namespace Database\Factories;

use App\Models\Agency;
use App\Models\Desa;
use App\Models\Negara;
use App\Models\Pendidikan;
use App\Models\Perusahaan;
use App\Models\TenagaKerja;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories.Factory<\App\Models\TenagaKerja>
 */
class TenagaKerjaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(array_keys(TenagaKerja::GENDERS));

        return [
            'nama' => fake()->name(),
            'nik' => fake()->unique()->numerify('################'),
            'gender' => $gender,
            'email' => fake()->unique()->safeEmail(),
            'no_telpon' => fake()->numerify('08###########'),
            'tempat_lahir' => fake()->city(),
            'tanggal_lahir' => fake()->dateTimeBetween('-45 years', '-18 years')->format('Y-m-d'),
            'alamat_lengkap' => fake()->address(),
            'desa_id' => Desa::factory(),
            'kode_pos' => fake()->numerify('#####'),
            'pendidikan_id' => Pendidikan::factory(),
            'perusahaan_id' => Perusahaan::factory(),
            'agency_id' => Agency::factory(),
            'negara_id' => Negara::factory(),
            'is_active' => fake()->randomElement(array_keys(TenagaKerja::STATUSES)),
        ];
    }
}
