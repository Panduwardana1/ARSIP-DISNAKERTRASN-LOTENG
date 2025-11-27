<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PendidikanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('pendidikan')?->id;

        return [
            'nama' => [
                'required',
                'string',
                'max:10',
                Rule::unique('pendidikans', 'nama')->ignore($id),
            ],
        ];
    }

    public function messages() : array {
        return [
            'nama.required' => 'Nama pendidikan harus diisi.',
            'nama.unique' => 'Nama pendidikan sudah digunakan.',
            'nama.max' => 'Nama pendidikan maksimal 10 karakter.',
        ];
    }

    protected function prepareForValidation() : void {
        $this->merge([
            'nama' => $this->normalize($this->input('nama')),
        ]);
    }

    private function normalize($value) : string {
        return trim(preg_replace('/\s+/', ' ', (string) $value));
    }

    public function attributes() : array {
        return [
            'nama' => 'Nama',
        ];
    }
}
