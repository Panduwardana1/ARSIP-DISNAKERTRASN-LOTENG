<?php

namespace App\Http\Requests;

use App\Models\Desa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DesaRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

     public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('desa')?->id;

        $uniqueNama = Rule::unique('desas')
            ->where(fn ($query) => $query->where('kecamatan_id', $this->input('kecamatan_id')));

        if ($this->isUpdate() && $id) {
            $uniqueNama = $uniqueNama->ignore($id);
        }

        return [
            'kecamatan_id' => ['required', 'integer', 'exists:kecamatans,id'],
            'nama' => ['required', 'string', 'max:50', $uniqueNama],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('nama')) {
            $this->merge([
                'nama' => trim($this->input('nama')),
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama desa harus diisi',
            'kecamatan_id.required' => 'Kecamatan harus dipilih',
            'kecamatan_id.exists' => 'Kecamatan tidak ditemukan',
            'nama.unique' => 'Nama desa sudah terpakai untuk kecamatan ini',
        ];
    }

    public function isCreate(): bool
    {
        return $this->isMethod('POST');
    }

    public function isUpdate(): bool
    {
        return $this->isMethod('PUT') || $this->isMethod('PATCH');
    }
}
