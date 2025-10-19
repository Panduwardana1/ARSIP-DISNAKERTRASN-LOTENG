<?php

namespace App\Http\Requests;

use App\Models\AgensiPenempatan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAgensiPenempatanRequest extends FormRequest
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
            'nama' => ['required', 'string', 'max:150', 'unique:agensi_penempatans,nama'],
            'lokasi' => ['nullable', 'string', 'max:1000'],
            'is_aktif' => ['required', Rule::in(array_keys(AgensiPenempatan::statusOptions()))],
            'gambar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama.unique' => 'Nama agensi sudah terdaftar.',
        ];
    }

    /**
     * Custom attribute names.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nama' => 'nama agensi',
            'lokasi' => 'lokasi agensi',
            'is_aktif' => 'status agensi',
            'gambar' => 'logo',
        ];
    }
}
