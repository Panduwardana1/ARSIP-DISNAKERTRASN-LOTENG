<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DashboardFilterRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'periode' => $this->input('periode', 'monthly'),
            'kecamatan' => $this->filled('kecamatan') ? trim((string) $this->input('kecamatan')) : null,
            'desa' => $this->filled('desa') ? trim((string) $this->input('desa')) : null,
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'periode' => ['nullable', Rule::in(['weekly', 'monthly', 'yearly'])],
            'kecamatan' => ['nullable', 'string', 'max:150'],
            'desa' => ['nullable', 'string', 'max:150'],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $data = parent::validated($key, $default);

        return array_filter($data, fn ($value) => $value !== null && $value !== '');
    }
}
