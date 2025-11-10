<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PendidikanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $pendidikan = $this->route('pendidikan');
        $pendidikanId = is_object($pendidikan) ? $pendidikan->getKey() : $pendidikan;

        return [
            'label' => [
                'required',
                'string',
                'max:100',
                Rule::unique('pendidikans', 'label')->ignore($pendidikanId),
            ],
            'nama' => [
                'required',
                'string',
                'max:10',
                'uppercase',
                Rule::unique('pendidikans', 'nama')->ignore($pendidikanId),
            ],
        ];
    }

    public function messages() : array {
        return [
            'nama.required' => 'Nama pendidikan harus diisi.',
            'nama.unique' => 'Nama pendidikan sudah digunakan.',
            'nama.max' => 'Nama pendidikan maksimal 10 karakter.',
            'label.required' => 'Label pendidikan harus diisi.',
            'label.max' => 'Label terlalu panjang.',
            'label.unique' => 'Label pendidikan sudah digunakan.',
        ];
    }

    protected function prepareForValidation() : void {
        $this->merge([
            'nama' => Str::upper(trim((string) $this->input('nama'))),
            'label' => trim((string) $this->input('label')),
        ]);
    }

    public function attributes() : array {
        return [
            'nama' => 'Nama',
            'label' => 'Label',
        ];
    }
}
