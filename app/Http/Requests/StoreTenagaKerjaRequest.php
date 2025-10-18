<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTenagaKerjaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'nik' => ['required', 'digits:16', 'unique:tenaga_kerjas,nik'],
            'gender' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'email' => ['nullable', 'email:dns', 'max:100'],
            'desa' => ['required', 'string', 'max:100'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'alamat_lengkap' => ['required', 'string', 'max:500'],
            'pendidikan_id' => ['required', Rule::exists('pendidikans_id', 'id')],
            'lowongan_id' => [
                'required',
                Rule::exists('lowongans_id', 'id')->where(fn($q) => $q->where('is_aktif', 'aktif'))
            ],
        ];
    }
}
