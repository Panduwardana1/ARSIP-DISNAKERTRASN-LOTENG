<?php

namespace Database\Factories;

use App\Models\Lowongan;
use App\Models\Pendidikan;
use App\Models\TenagaKerja;
use Illuminate\Database\Eloquent\Factories\Factory;
use RuntimeException;

/**
 * @extends Factory<TenagaKerja>
 */
class TenagaKerjaFactory extends Factory
{
    protected $model = TenagaKerja::class;

    public function definition(): array
    {
        $genderLabel = $this->faker->randomElement(['Laki-laki', 'Perempuan']);

        $pendidikanId = Pendidikan::query()->inRandomOrder()->value('id');
        if (!$pendidikanId) {
            throw new RuntimeException('TenagaKerjaFactory membutuhkan data pendidikan. Jalankan PendidikanSeeder terlebih dahulu.');
        }

        $lowonganId = Lowongan::query()->inRandomOrder()->value('id');
        if (!$lowonganId) {
            throw new RuntimeException('TenagaKerjaFactory membutuhkan data lowongan. Tambahkan lowongan terlebih dahulu sebelum membuat tenaga kerja dummy.');
        }

        return [
            'nama' => $this->faker->name($genderLabel === 'Laki-laki' ? 'male' : 'female'),
            'nik' => $this->faker->unique()->numerify(str_repeat('#', 16)),
            'gender' => $genderLabel,
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->dateTimeBetween('-40 years', '-18 years'),
            'email' => $this->faker->unique()->safeEmail(),
            'desa' => $this->faker->citySuffix(),
            'kecamatan' => $this->faker->city(),
            'alamat_lengkap' => $this->faker->address(),
            'pendidikan_id' => $pendidikanId,
            'lowongan_id' => $lowonganId,
        ];
    }
}
