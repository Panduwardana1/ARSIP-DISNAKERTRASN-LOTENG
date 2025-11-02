<?php

namespace Database\Seeders;

use App\Models\Pendidikan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pendidikans = [
            ['nama' => 'Sekolah Dasar', 'level' => 'SD'],
            ['nama' => 'Sekolah Menengah Pertama', 'level' => 'SMP'],
            ['nama' => 'Sekolah Menengah Atas', 'level' => 'SMA'],
            ['nama' => 'Diploma 1', 'level' => 'D1'],
            ['nama' => 'Diploma 2', 'level' => 'D2'],
            ['nama' => 'Diploma 3', 'level' => 'D3'],
            ['nama' => 'Sarjana (S1)', 'level' => 'S1'],
            ['nama' => 'Magister (S2)', 'level' => 'S2'],
            ['nama' => 'Doktor (S3)', 'level' => 'S3'],
        ];

        DB::transaction(function () use ($pendidikans) {
            foreach ($pendidikans as $data) {
                Pendidikan::query()->updateOrCreate(
                    ['nama' => $data['nama']],
                    ['level' => $data['level']]
                );
            }
        });
    }
}
