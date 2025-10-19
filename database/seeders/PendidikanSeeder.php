<?php

namespace Database\Seeders;

use App\Models\Pendidikan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pendidikans = [
            ['kode' => 'SD', 'nama' => 'Sekolah Dasar', 'level' => 'SD'],
            ['kode' => 'SMP', 'nama' => 'Sekolah Menengah Pertama', 'level' => 'SMP'],
            ['kode' => 'SMA', 'nama' => 'Sekolah Menengah Atas', 'level' => 'SMA'],
            ['kode' => 'D1', 'nama' => 'Diploma 1', 'level' => 'D1'],
            ['kode' => 'D2', 'nama' => 'Diploma 2', 'level' => 'D2'],
            ['kode' => 'D3', 'nama' => 'Diploma 3', 'level' => 'D3'],
            ['kode' => 'S1', 'nama' => 'Sarjana (S1)', 'level' => 'S1'],
            ['kode' => 'S2', 'nama' => 'Magister (S2)', 'level' => 'S2'],
            ['kode' => 'S3', 'nama' => 'Doktor (S3)', 'level' => 'S3'],
        ];

        DB::transaction(function () use ($pendidikans) {
            foreach ($pendidikans as $data) {
                Pendidikan::query()->updateOrCreate(
                    ['kode' => $data['kode']],
                    ['nama' => $data['nama'], 'level' => $data['level']]
                );
            }
        });
    }
}
