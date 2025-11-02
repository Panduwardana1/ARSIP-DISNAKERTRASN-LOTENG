<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class KecamatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $routeParam = $this->route('kecamatan');
        $id = $routeParam instanceof \App\Models\Kecamatan ? $routeParam->id : $routeParam;

        $requiredRules = ($this->isMethod('patch') || $this->isMethod('put'))
            ? ['sometimes', 'required']
            : ['required'];

        return [
            'nama' => [
                ...$requiredRules,
                'string',
                'max:100',
                Rule::unique('kecamatans', 'nama')->ignore($id),
            ],
            'kode' => [
                ...$requiredRules,
                'string',
                'max:10',
                Rule::unique('kecamatans', 'kode')->ignore($id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama kecamatan wajib diisi.',
            'nama.max' => 'Nama kecamatan maksimal 100 karakter.',
            'nama.unique' => 'Nama kecamatan sudah digunakan.',
            'kode.required' => 'Kode kecamatan wajib diisi.',
            'kode.max' => 'Kode kecamatan maksimal 10 karakter.',
            'kode.unique' => 'Kode kecamatan sudah digunakan.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'Nama Kecamatan',
            'kode' => 'Kode Kecamatan',
        ];
    }

    protected function prepareForValidation(): void
    {
        $nama = preg_replace('/\s+/u', ' ', trim((string) $this->nama));
        $kode = strtoupper(trim((string) $this->kode));

        $this->merge([
            'nama' => $nama,
            'kode' => $kode,
        ]);
    }
}
