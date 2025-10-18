<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePerusahaanIndonesiaRequest extends FormRequest
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
            'nama' => ['required', 'string', 'max:100'],
            'nama_pimpinan' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email:filter', 'max:100'],
            'nomor_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'gambar' => ['nullable', 'image', 'mimes:png,jpg', 'max:2048'],
        ];
    }
}
