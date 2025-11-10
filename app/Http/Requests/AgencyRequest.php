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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $agency = $this->route('agency');
        $agencyId = $agency instanceof Agency ? $agency->getKey() : $agency;

        $uniqueNama = Rule::unique('agencies', 'nama')
            ->where(fn ($query) => $query->whereNull('deleted_at'));

        if ($agencyId !== null) {
            $uniqueNama = $uniqueNama->ignore($agencyId);
        }

        return [
            'nama' => ['required', 'string', 'max:100', $uniqueNama],
            'perusahaan_id' => [
                'required',
                Rule::exists('perusahaans', 'id')->whereNull('deleted_at'),
            ],
            'lowongan' => ['nullable', 'string', 'max:100'],
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
        $normalized = collect($this->only(['nama', 'lowongan', 'keterangan']))
            ->map(function ($value) {
                if (is_string($value)) {
                    $value = trim($value);
                    return $value === '' ? null : $value;
                }

                return $value;
            })
            ->toArray();

        $this->merge(array_merge($normalized, [
            'perusahaan_id' => $this->filled('perusahaan_id')
                ? (int) $this->input('perusahaan_id')
                : null,
        ]));
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
