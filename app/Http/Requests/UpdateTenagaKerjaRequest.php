<?php

namespace App\Http\Requests;

use App\Models\Lowongan;
use App\Models\TenagaKerja;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTenagaKerjaRequest extends FormRequest
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
        $tenagaKerja = $this->route('cpmi');
        $currentLowonganId = (int) optional($tenagaKerja)->lowongan_id;

        return [
            'nama' => ['required', 'string', 'max:150'],
            'nik' => [
                'required',
                'digits:16',
                Rule::unique('tenaga_kerjas', 'nik')->ignore(optional($tenagaKerja)->id),
            ],
            'gender' => ['required', Rule::in(array_keys(TenagaKerja::genderOptions()))],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today', 'after:1900-01-01'],
            'email' => ['nullable', 'email:filter', 'max:100'],
            'desa' => ['required', 'string', 'max:100'],
            'kecamatan' => ['required', 'string', 'max:100'],
            'alamat_lengkap' => ['required', 'string', 'max:500'],
            'pendidikan_id' => ['required', Rule::exists('pendidikans', 'id')],
            'lowongan_id' => [
                'required',
                Rule::exists('lowongans', 'id')->where(function ($query) use ($currentLowonganId) {
                    $query->when(
                        (int) $this->input('lowongan_id') !== $currentLowonganId,
                        fn($q) => $q->where('is_aktif', Lowongan::STATUS_AKTIF)
                    );
                }),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama' => $this->nama ? trim($this->nama) : $this->nama,
            'nik' => $this->nik ? preg_replace('/\D+/', '', $this->nik) : $this->nik,
            'tempat_lahir' => $this->tempat_lahir ? trim($this->tempat_lahir) : $this->tempat_lahir,
            'email' => $this->email ? trim($this->email) : $this->email,
            'desa' => $this->desa ? trim($this->desa) : $this->desa,
            'kecamatan' => $this->kecamatan ? trim($this->kecamatan) : $this->kecamatan,
            'alamat_lengkap' => $this->alamat_lengkap ? trim($this->alamat_lengkap) : $this->alamat_lengkap,
        ]);
    }

    public function messages(): array
    {
        return [
            'nik.unique' => 'NIK sudah terdaftar pada data CPMI lain.',
            'nik.digits' => 'NIK harus terdiri dari 16 digit angka.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh melebihi tanggal hari ini.',
            'tanggal_lahir.after' => 'Tanggal lahir tidak boleh sebelum tahun 1900.',
            'gender.in' => 'Jenis kelamin harus Laki-laki atau Perempuan.',
            'pendidikan_id.exists' => 'Pendidikan yang dipilih tidak valid.',
            'lowongan_id.exists' => 'Lowongan yang dipilih tidak tersedia atau tidak aktif.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama lengkap',
            'nik' => 'NIK',
            'gender' => 'jenis kelamin',
            'tempat_lahir' => 'tempat lahir',
            'tanggal_lahir' => 'tanggal lahir',
            'email' => 'email',
            'desa' => 'desa',
            'kecamatan' => 'kecamatan',
            'alamat_lengkap' => 'alamat lengkap',
            'pendidikan_id' => 'pendidikan terakhir',
            'lowongan_id' => 'lowongan tujuan',
        ];
    }
}
