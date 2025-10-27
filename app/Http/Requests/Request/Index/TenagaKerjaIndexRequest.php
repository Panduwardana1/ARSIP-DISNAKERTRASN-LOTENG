<?php

namespace App\Http\Requests\Request\Index;

use Closure;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TenagaKerjaIndexRequest extends FormRequest
{
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
        return [
            'keyword' => [
                'nullable',
                'string',
                'max:100',
                function (string $attribute, mixed $value, Closure $fail): void {
                    $normalized = preg_replace('/\s+/', ' ', trim((string) $value));

                    if ($normalized === '') {
                        return;
                    }

                    if (!preg_match('/^[\pL\pM0-9\s\'\-.]+$/u', $normalized)) {
                        $fail('Kata kunci hanya boleh berisi huruf, angka, spasi, apostrof, titik, atau tanda hubung.');
                        return;
                    }

                    $digitsOnly = preg_replace('/\D+/', '', $normalized);
                    $isNumericKeyword = preg_match('/^\d+$/', str_replace(' ', '', $normalized)) === 1;

                    if ($isNumericKeyword && strlen($digitsOnly) < 4) {
                        $fail('Kata kunci NIK minimal 4 digit.');
                        return;
                    }

                    if (!$isNumericKeyword && mb_strlen(str_replace(' ', '', $normalized)) < 3) {
                        $fail('Kata kunci nama minimal 3 karakter.');
                    }
                },
            ],
            'gender' => ['nullable', Rule::in(['Laki-laki', 'Perempuan'])],
            'pendidikan' => ['nullable', 'integer', 'exists:pendidikans,id'],
            'lowongan'  => ['nullable', 'integer', 'exists:lowongans,id'],
            'page'  => ['nullable', 'integer', 'min:1'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $keyword = preg_replace('/\s+/', ' ', (string) $this->keyword);

        $this->merge([
            'keyword' => trim($keyword),
        ]);
    }

    public function filters(): array
    {
        $validated = $this->validated();

        return [
            'keyword'   => trim((string) ($validated['keyword'] ?? '')),
            'gender'    => $validated['gender'] ?? null,
            'pendidikan'    => $validated['pendidikan'] ?? null,
            'lowongan'    => $validated['lowongan'] ?? null,
        ];
    }
}
