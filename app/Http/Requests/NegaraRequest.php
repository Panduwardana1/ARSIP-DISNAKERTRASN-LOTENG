<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class NegaraRequest extends FormRequest
{
    protected $stopOnFirstFailure;
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
        $negaraId = $this->route('negara')?->id;

        return [
            'nama' => [
                'required',
                'string',
                'uppercase',
                'max:100',
                Rule::unique('negaras', 'nama')->ignore($negaraId),
            ],
            'kode_iso' => [
                'nullable',
                'string',
                'uppercase',
                'max:5',
                Rule::unique('negaras', 'kode_iso')->ignore($negaraId),
            ],
        ];
    }

    protected function prepareForValidation() : void {
        $this->merge([
            'nama' => trim(Str::upper((string) $this->input('nama'))),
            'kode_iso' => trim(Str::upper((string) $this->input('kode_iso'))),
        ]);
    }

    public function messages() : array {
        return [
            'nama.required' => 'Nama negara harus diisi',
            'nama.unique' => 'Nama negara telah digunakan',
            'nama.max' => 'Nama terlalu panjang',
            'kode_iso.required' => 'Kode Iso harus diisi',
            'kode_iso.unique' => 'Kode iso telah digunakan',
            'kode_iso.max' => 'Kode iso terlalu panjang',
        ];
    }

    public function attributes() : array {
        return [
            'nama' => 'Nama',
            'kode_iso' => 'Kode Iso',
        ];
    }
}
