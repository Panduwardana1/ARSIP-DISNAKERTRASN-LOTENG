<?php

namespace Database\Seeders;

use App\Models\AgensiPenempatan;
use App\Models\Destinasi;
use App\Models\Lowongan;
use App\Models\Pendidikan;
use App\Models\PerusahaanIndonesia;
use App\Models\TenagaKerja;
use Illuminate\Database\Seeder;

class TenagaKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan referensi wajib tersedia
        if (Pendidikan::count() === 0) {
            $this->call(PendidikanSeeder::class);
        }

        $agensis = [
            AgensiPenempatan::query()->firstOrCreate(
                ['nama' => 'PT Maju Jaya Abadi'],
                ['lokasi' => 'Jakarta', 'gambar' => null, 'is_aktif' => 'aktif']
            ),
            AgensiPenempatan::query()->firstOrCreate(
                ['nama' => 'PT Global Mitra Sentosa'],
                ['lokasi' => 'Surabaya', 'gambar' => null, 'is_aktif' => 'aktif']
            ),
        ];

        $perusahaans = [
            PerusahaanIndonesia::query()->firstOrCreate(
                ['nama' => 'PT Sejahtera Makmur'],
                [
                    'nama_pimpinan' => 'Budi Santoso',
                    'email' => 'sejahtera@example.com',
                    'nomor_hp' => '0211234567',
                    'alamat' => 'Jl. Industri No. 10, Jakarta',
                ]
            ),
            PerusahaanIndonesia::query()->firstOrCreate(
                ['nama' => 'PT Cemerlang Nusantara'],
                [
                    'nama_pimpinan' => 'Siti Rahmawati',
                    'email' => 'cemerlang@example.com',
                    'nomor_hp' => '0317654321',
                    'alamat' => 'Jl. Raya Industri No. 77, Surabaya',
                ]
            ),
        ];

        $destinasis = [
            Destinasi::query()->firstOrCreate(
                ['kode' => 'SGP'],
                ['nama' => 'Singapura', 'benua' => 'Asia']
            ),
            Destinasi::query()->firstOrCreate(
                ['kode' => 'HKG'],
                ['nama' => 'Hong Kong', 'benua' => 'Asia']
            ),
        ];

        $lowonganConfigs = [
            ['nama' => 'Caregiver', 'agensi' => $agensis[0], 'perusahaan' => $perusahaans[0], 'destinasi' => $destinasis[0]],
            ['nama' => 'Operator Pabrik', 'agensi' => $agensis[1], 'perusahaan' => $perusahaans[1], 'destinasi' => $destinasis[1]],
        ];

        $lowonganIds = [];
        foreach ($lowonganConfigs as $config) {
            $lowongan = Lowongan::query()->firstOrCreate(
                [
                    'nama' => $config['nama'],
                    'agensi_id' => $config['agensi']->id,
                    'perusahaan_id' => $config['perusahaan']->id,
                ],
                [
                    'destinasi_id' => $config['destinasi']->id,
                    'is_aktif' => 'aktif',
                    'catatan' => null,
                ]
            );
            $lowonganIds[] = $lowongan->id;
        }

        $pendidikanIds = Pendidikan::query()->pluck('id')->all();

        TenagaKerja::factory()
            ->count(50)
            ->state(function () use ($lowonganIds, $pendidikanIds) {
                return [
                    'pendidikan_id' => collect($pendidikanIds)->random(),
                    'lowongan_id' => collect($lowonganIds)->random(),
                ];
            })
            ->create();
    }
}
