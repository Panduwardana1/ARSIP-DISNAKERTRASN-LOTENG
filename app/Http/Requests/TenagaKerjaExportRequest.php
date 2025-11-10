<?php

namespace App\Http\Requests;

use App\Models\TenagaKerja;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TenagaKerjaExportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tahun' => ['nullable', 'integer', 'min:2000', 'max:' . now()->addYear()->year],
            'bulan' => ['nullable', 'integer', 'between:1,12'],
            'minggu' => ['nullable', 'integer', 'min:0', 'max:52'],
            'gender' => ['nullable', Rule::in(array_keys(TenagaKerja::GENDERS))],
            'kecamatan_id' => ['nullable', 'exists:kecamatans,id'],
            'desa_id' => ['nullable', 'exists:desas,id'],
            'perusahaan_id' => ['nullable', 'exists:perusahaans,id'],
            'agency_id' => ['nullable', 'exists:agencies,id'],
            'negara_id' => ['nullable', 'exists:negaras,id'],
        ];
    }
}
