<?php

use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('nama desa harus unik dalam kecamatan yang sama', function () {
    $kecamatan = Kecamatan::factory()->create();
    Desa::factory()->create([
        'kecamatan_id' => $kecamatan->id,
        'nama' => 'SIDO RUKUN',
    ]);

    $response = $this
        ->from(route('sirekap.desa.create'))
        ->post(route('sirekap.desa.store'), [
            'kecamatan_id' => $kecamatan->id,
            'nama' => 'Sido Rukun',
        ]);

    $response->assertRedirect(route('sirekap.desa.create'));
    $response->assertInvalid([
        'nama' => 'Nama desa sudah terpakai untuk kecamatan ini',
    ]);
});

test('nama desa boleh sama di kecamatan berbeda dan otomatis di-uppercase', function () {
    $firstKecamatan = Kecamatan::factory()->create();
    $secondKecamatan = Kecamatan::factory()->create();

    Desa::factory()->create([
        'kecamatan_id' => $firstKecamatan->id,
        'nama' => 'LIMAU MANIS',
    ]);

    $response = $this->post(route('sirekap.desa.store'), [
        'kecamatan_id' => $secondKecamatan->id,
        'nama' => 'limau manis',
    ]);

    $response->assertRedirect(route('sirekap.desa.index'));

    $this->assertDatabaseHas('desas', [
        'kecamatan_id' => $secondKecamatan->id,
        'nama' => 'LIMAU MANIS',
    ]);
});
