<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RekomendasiRequest extends FormRequest
{
    protected $redirectRoute = 'sirekap.rekomendasi.preview';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode' => [
                'required',
                'string',
                'max:100',
                Rule::unique('rekomendasis', 'kode'),
            ],
            'tanggal' => ['required', 'date'],
            'author_id' => ['required', 'integer', Rule::exists('authors', 'id')],
            'tenaga_kerja_ids' => ['required', 'array', 'min:1'],
            'tenaga_kerja_ids.*' => ['integer', 'distinct', Rule::exists('tenaga_kerjas', 'id')],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'kode' => str($this->input('kode'))->trim()->toString(),
            'tenaga_kerja_ids' => collect($this->input('tenaga_kerja_ids', []))
                ->filter(fn ($id) => ! empty($id))
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values()
                ->all(),
        ]);
    }

    public function attributes(): array
    {
        return [
            'kode' => 'Kode rekomendasi',
            'tanggal' => 'Tanggal rekomendasi',
            'author_id' => 'Author',
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
