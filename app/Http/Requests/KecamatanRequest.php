<?php

namespace App\Http\Requests;

use App\Models\Kecamatan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KecamatanRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kecamatanId = $this->route('kecamatan');

        if ($kecamatanId instanceof Kecamatan) {
            $kecamatanId = $kecamatanId->getKey();
        }

        $namaRule = Rule::unique('kecamatans', 'nama');
        $kodeRule = Rule::unique('kecamatans', 'kode');

        if ($kecamatanId) {
            $namaRule->ignore($kecamatanId);
            $kodeRule->ignore($kecamatanId);
        }

        return [
            'nama' => ['required', 'string', 'max:100', $namaRule],
            'kode' => ['nullable', 'string', 'max:10', $kodeRule],
        ];
    }

    protected function prepareForValidation() {
        $nama = $this->input('nama');
        $kode = $this->input('kode');

        $this->merge([
            'nama' => $nama ? strtoupper(trim($nama)) : null,
            'kode' => $kode ? strtoupper(trim($kode)) : null,
        ]);
    }

    public function messages() : array {
        return [
            'nama.required' => 'Nama kecamatan Wajib diisi',
            'nama.max' => 'Nama terlalu panjang',
            'nama.unique' => 'Nama kecmatan sudah digunakan',
            'kode.unique' => 'Kode tidak valid',
            'kode.max' => 'kode tidak boleh melebihi 10 angka',
        ];
    }

    public function attributes() : array {
        return [
            'nama' => 'Nama',
            'kode' => 'Kode',
        ];
    }
}
