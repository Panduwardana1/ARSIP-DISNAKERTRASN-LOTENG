<?php

namespace App\Http\Requests;

use App\Models\Agency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgencyRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = optional($this->route('agency'))->id;

        return [
            'nama' => ['required', 'string', 'max:100', Rule::unique('agencies', 'nama')
                ->ignore($id)],
            'perusahaan_id' => [
                'required',
                'exists:perusahaans,id',
            ],
            'lowongan' => ['required', 'string', 'max:100'],
            'keterangan' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama agency wajib diisi.',
            'nama.string' => 'Nama agency harus berupa teks.',
            'nama.max' => 'Nama agency maksimal 100 karakter.',
            'nama.unique' => 'Nama agency sudah terdaftar.',
            'perusahaan_id.required' => 'Perusahaan wajib dipilih.',
            'perusahaan_id.exists' => 'Perusahaan tidak valid atau sudah dihapus.',
            'lowongan.string' => 'Lowongan harus berupa teks.',
            'lowongan.max' => 'Lowongan maksimal 100 karakter.',
            'keterangan.string' => 'Keterangan harus berupa teks.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama'
        ]);
    }

    public function attributes() : array {
        return [
            'nama' => 'Nama',
            'perusahaan_id' => 'Perusahaan',
            'lowongan' => 'Lowongan',
            'keterangan' => 'Keterangan',
        ];
    }
}
