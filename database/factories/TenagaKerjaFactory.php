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
 * @extends Factory<TenagaKerja>
 */
class TenagaKerjaFactory extends Factory
{
    protected $model = TenagaKerja::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = fake('id_ID');
        $gender = $faker->randomElement(array_keys(TenagaKerja::GENDERS));

        return [
            'nama' => $faker->name($gender === 'L' ? 'male' : 'female'),
            'nik' => $faker->unique()->numerify(str_repeat('#', 16)),
            'gender' => $gender,
            'email' => $faker->unique()->safeEmail(),
            'no_telpon' => $faker->numerify('08##########'),
            'tempat_lahir' => $faker->city(),
            'tanggal_lahir' => $faker->dateTimeBetween('-45 years', '-18 years')->format('Y-m-d'),
            'alamat_lengkap' => $faker->address(),
            'desa_id' => Desa::factory(),
            'kode_pos' => $faker->postcode(),
            'pendidikan_id' => Pendidikan::factory(),
            'perusahaan_id' => Perusahaan::factory(),
            'agency_id' => Agency::factory(),
            'negara_id' => Negara::factory(),
        ];
    }
}
