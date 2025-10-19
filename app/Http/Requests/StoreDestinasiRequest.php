<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDestinasiRequest extends FormRequest
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
            'nama' => ['required', 'string', 'max:150'],
            'kode' => ['required', 'string', 'size:3', 'regex:/^[A-Z]{3}$/', 'unique:destinasis,kode'],
            'benua' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode.regex' => 'Kode harus berupa tiga huruf kapital (A-Z).',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama destinasi',
            'kode' => 'kode negara',
            'benua' => 'benua',
        ];
    }
}
