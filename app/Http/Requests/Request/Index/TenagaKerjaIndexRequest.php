<?php

namespace App\Http\Requests\Request\Index;

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
            'keyword' => ['nullable', 'string', 'max:100'],
            'gender' => ['nullable', Rule::in(['Laki-laki', 'Perempuan'])],
            'pendidikan' => ['nullable', 'integer', 'exists:pendidikans,id'],
            'lowongan'  => ['nullable', 'integer', 'exists:lowongans,id'],
            'page'  => ['nullable', 'integer', 'min:1'],
        ];
    }

    protected function prepareForValidation() : void
    {
        $this->merge([
            'keyword' => trim((string) $this->keyword)
        ]);
    }

    public function filters() : array {
        $validated = $this->validated();

        return [
            'keyword'   => (string) ($validated['keyword'] ?? ''),
            'gender'    => $validated['gender'] ?? null,
            'pendidikan'    => $validated['pendidikan'] ?? null,
            'lowongan'    => $validated['lowongan'] ?? null,
        ];
    }
}
