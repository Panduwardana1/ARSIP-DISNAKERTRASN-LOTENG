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
        $id = $this->route('kecamatan')?->id;

        return [
            'nama' => ['required', 'string', 'max:100', Rule::unique('kecamatans', 'nama')->ignore($id)],
        ];
    }

    protected function prepareForValidation() {
        $nama = $this->input('nama');

        $this->merge([
            'nama' => $nama ? trim($nama) : null,
        ]);
    }

    public function messages() : array {
        return [
            'nama.required' => 'Nama kecamatan Wajib diisi',
            'nama.max' => 'Nama terlalu panjang',
            'nama.unique' => 'Nama kecmatan sudah digunakan',
        ];
    }

    public function attributes() : array {
        return [
            'nama' => 'Nama',
        ];
    }
}
