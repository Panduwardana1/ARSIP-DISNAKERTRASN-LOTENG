<?php

namespace App\Http\Requests;

use App\Models\Pendidikan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PendidikanRequest extends FormRequest
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
        $routeParam = $this->route('pendidikan');
        $pendidikan = $routeParam instanceof Pendidikan ? $routeParam : Pendidikan::find($routeParam);
        $id = $pendidikan?->id ?? $routeParam;

        $requiredRules = ($this->isMethod('patch') || $this->isMethod('put'))
            ? ['sometimes', 'required']
            : ['required'];

        return [
            'nama' => [
                ...$requiredRules,
                'string',
                'max:50',
                Rule::unique('pendidikans', 'nama')->ignore($id),
            ],
            'level' => [
                ...$requiredRules,
                Rule::in(Pendidikan::LEVELS),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama pendidikan wajib diisi.',
            'nama.unique' => 'Nama pendidikan sudah digunakan.',
            'level.required' => 'Level pendidikan wajib dipilih.',
            'level.in' => 'Level pendidikan tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'Nama Pendidikan',
            'level' => 'Level Pendidikan',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama' => $this->filled('nama') ? preg_replace('/\s+/u', ' ', trim((string) $this->nama)) : null,
            'level' => $this->filled('level') ? strtoupper(trim((string) $this->level)) : null,
        ]);
    }
}
