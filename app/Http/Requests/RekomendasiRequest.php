<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RekomendasiRequest extends FormRequest
{
    protected $redirectRoute = 'sirekap.rekomendasi.preview';

    public function rules(): array
    {
       return [
            'kode' => ['required','string','max:100'],
            'tanggal' => ['required','date'],
            'author_id' => ['required','exists:authors,id'],
            'perusahaan_id' => ['required','exists:perusahaans,id'],
            'negara_id' => ['required','exists:negaras,id'],
            'tenaga_kerja_ids' => ['required','array','min:1'],
            'tenaga_kerja_ids.*' => ['integer','exists:tenaga_kerjas,id'],
            'action' => ['required','in:print'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'kode' => trim(Str::upper((string) $this->input('kode'))),
            'perusahaan_id' => (int) $this->input('perusahaan_id'),
            'negara_id' => (int) $this->input('negara_id'),
            'tenaga_kerja_ids' => collect($this->input('tenaga_kerja_ids', []))
                ->filter(fn ($id) => ! empty($id))
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values()
                ->all(),
            'submit_action' => $this->input('submit_action', 'save'),
        ]);
    }

    public function attributes(): array
    {
        return [
            'kode' => 'Kode rekomendasi',
            'tanggal' => 'Tanggal rekomendasi',
            'author_id' => 'Author',
            'perusahaan_id' => 'Perusahaan',
            'negara_id' => 'Negara',
            'tenaga_kerja_ids' => 'Tenaga kerja',
            'tenaga_kerja_ids.*' => 'Tenaga kerja',
        ];
    }

    public function messages(): array
    {
        return [
            'tenaga_kerja_ids.required' => 'Pilih minimal satu tenaga kerja.',
            'tenaga_kerja_ids.array' => 'Format tenaga kerja tidak valid.',
            'tenaga_kerja_ids.min' => 'Minimal satu tenaga kerja harus dipilih.',
            'tenaga_kerja_ids.*.distinct' => 'Data tenaga kerja tidak boleh duplikat.',
        ];
    }
}
