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
        $lowonganId = $this->route('lowongan')?->id;

        return [
            'nama' => ['required', 'string', 'max:150'],
            'agensi_id' => ['required', 'exists:agensi_penempatans,id'],
            'perusahaan_id' => ['required', 'exists:perusahaan_indonesias,id'],
            'destinasi_id' => ['required', 'exists:destinasis,id'],
            'kontrak_kerja' => [
                'required',
                'integer',
                'between:1,65535',
                Rule::unique('lowongans', 'kontrak_kerja')
                    ->ignore($lowonganId)
                    ->where(function ($query) {
                        return $query
                            ->where('agensi_id', $this->input('agensi_id'))
                            ->where('perusahaan_id', $this->input('perusahaan_id'));
                    }),
            ],
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
            'kontrak_kerja' => 'nomor kontrak kerja',
            'is_aktif' => 'status lowongan',
            'catatan' => 'catatan',
        ];
    }
}
