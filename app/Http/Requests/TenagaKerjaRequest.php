<?php

namespace App\Http\Requests;

use App\Models\TenagaKerja;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TenagaKerjaRequest extends FormRequest
{

    protected $stopOnFirstFailurel;
    public function rules(): array
    {
        $tenagaKerja = $this->route('tenaga_kerja');

        $tenagaKerjaId = is_object($tenagaKerja) ? $tenagaKerja->getKey() : $tenagaKerja;

        return [
            'nama' => ['required', 'string','regex:/^[A-Za-z\s\',\.]+$/', 'max:100'],
            'nik' => ['required', 'digits:16', 'regex:/^[0-9]+$/', Rule::unique('tenaga_kerjas', 'nik')->ignore($tenagaKerjaId)],
            'gender' => ['required', Rule::in(array_keys(TenagaKerja::GENDERS))],
            'email' => ['nullable', 'string', 'email', 'max:100', Rule::unique('tenaga_kerjas', 'email')->ignore($tenagaKerjaId)],
            'no_telpon' => ['nullable', 'digits_between:10,15', 'regex:/^[0-9]+$/'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
            'alamat_lengkap' => ['required', 'string', 'max:500'],
            'desa_id' => ['required', Rule::exists('desas', 'id')],
            'kode_pos' => ['nullable', 'digits_between:3,10', 'regex:/^[0-9]+$/'],
            'pendidikan_id' => ['required', Rule::exists('pendidikans', 'id')],
            'perusahaan_id' => ['required', Rule::exists('perusahaans', 'id')],
            'agency_id' => ['required', Rule::exists('agencies', 'id')],
            'negara_id' => ['required', Rule::exists('negaras', 'id')],
        ];
    }

    protected function prepareForValidation() : void {
        $cleanPhone = preg_replace('/\D/', '', (string) $this->input('no_telpon'));
        $cleanPostal = preg_replace('/\D/', '', (string) $this->input('kode_pos'));

        $this->merge([
            'nama' => trim((string) Str::title($this->input('nama'))),
            'email' => $this->filled('email') ? trim(Str::lower($this->input('email'))) : null,
            'nik' => preg_replace('/\D/', '', (string) $this->input('nik')),
            'no_telpon' => $cleanPhone !== '' ? $cleanPhone : null,
            'kode_pos' => $cleanPostal !== '' ? $cleanPostal : null,
        ]);
    }

    public function messages() : array {
        return [
            'nama.required' => 'Nama harus diisi',
            'nama.regex' => 'Nama tidak boleh menggunakan karakter simbol',
            'email.unique' => 'Alamat email sudah digunakan',
            'nik.required' => 'No NIK harus diisi',
            'nik.regex' => 'NIK tidak boleh menggunakan karakter simbol',
            'nik.unique' => 'No NIK sudah digunakan atau kurang lengkap',
        ];
    }

    public function attributes() : array {
        return [
            'nama' => 'Nama',
            'nik' => 'NIK',
            'email' => 'Email',
            'no_telpon' => 'No Telpon',
            'tempat_lahir' => 'Tempat Lahir',
            'alamat_lengkap' => 'Alamat Lengkap',
            'negara_id' => 'Negara Tujuan',
        ];
    }
}
