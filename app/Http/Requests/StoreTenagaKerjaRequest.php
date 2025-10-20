<?php

namespace App\Http\Requests;

use App\Models\TenagaKerja;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTenagaKerjaRequest extends FormRequest
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
            'nama' => ['required', 'string', 'max:255'],
            'nik'   => ['required', 'digits:16', 'unique:tenaga_kerjas,nik'],
            'gender' => ['required', Rule::in(TenagaKerja::GENDERS)],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
            'email' => ['nullable', 'email:rfc,dns', 'max:100'],
            'desa' => ['required', 'string', 'max:100'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'alamat_lengkap' => ['required', 'string'],
            'pendidikan_id' => ['required', 'integer', 'exists:pendidikans,id'],
            'lowongan_id'   => ['required', 'integer', 'exists:lowongans,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'Nama',
            'nik'   => 'NIK',
            'gender' => 'Jenis Kelamin',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'email' => 'Email',
            'desa' => 'Desa',
            'kecamatan' => 'Kecamatan',
            'alamat_lengkap' => 'Alamat lengkap',
            'pendidikan_id' => 'Pendidikan',
            'lowongan_id' => 'Lowongan',
        ];
    }

    public function messages(): array
    {
        return [
            'nik.digits' => 'NIK harus 16 digit.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh melebihi hari ini.'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama'           => trim((string) $this->nama),
            'nik'            => preg_replace('/\D/', '', (string) $this->nik),
            'tempat_lahir'   => trim((string) $this->tempat_lahir),
            'email'          => $this->email ? trim((string) $this->email) : null,
            'desa'           => trim((string) $this->desa),
            'kecamatan'      => trim((string) $this->kecamatan),
            'alamat_lengkap' => trim((string) $this->alamat_lengkap),
        ]);
    }
}
