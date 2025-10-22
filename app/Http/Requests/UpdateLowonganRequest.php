<?php

namespace App\Http\Requests;

use App\Models\Lowongan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLowonganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:150'],
            'agensi_id' => ['required', 'exists:agensi_penempatans,id'],
            'perusahaan_id' => ['required', 'exists:perusahaan_indonesias,id'],
            'destinasi_id' => ['required', 'exists:destinasis,id'],
            'is_aktif' => ['required', Rule::in(array_keys(Lowongan::statusOptions()))],
            'catatan' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama lowongan',
            'agensi_id' => 'agensi penempatan',
            'perusahaan_id' => 'perusahaan',
            'destinasi_id' => 'destinasi',
            'is_aktif' => 'status lowongan',
            'catatan' => 'catatan',
        ];
    }
}
