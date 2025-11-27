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
        $id = $this->route('negara')?->id;

        return [
            'nama' => [
                'required',
                'string',
                'max:100',
                Rule::unique('negaras', 'nama')->ignore($id),
            ],
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

    public function messages() : array {
        return [
            'nama.required' => 'Nama negara harus diisi',
            'nama.unique' => 'Nama negara telah digunakan',
            'nama.max' => 'Nama terlalu panjang',
        ];
    }

    public function attributes() : array {
        return [
            'nama' => 'Nama',
        ];
    }
}
