<?php

namespace App\Http\Requests;

use App\Models\TenagaKerja;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TenagaKerjaRequest extends FormRequest
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
        $routeParam = $this->route('tenaga_kerja');
        $tenagaKerja = $routeParam instanceof TenagaKerja ? $routeParam : TenagaKerja::find($routeParam);
        $id = $tenagaKerja?->id ?? $routeParam;

        $requiredRules = ($this->isMethod('patch') || $this->isMethod('put'))
            ? ['sometimes', 'required']
            : ['required'];

        $kecamatanId = $this->input('kecamatan_id', $tenagaKerja?->kecamatan_id);

        return [
            'nama' => [...$requiredRules, 'string', 'max:255'],
            'nik' => [
                ...$requiredRules,
                'bail',
                'digits:16',
                Rule::unique('tenaga_kerjas', 'nik')->ignore($id),
            ],
            'gender' => [...$requiredRules, Rule::in(['L', 'P'])],
            'email' => ['sometimes', 'nullable', 'email', 'max:100'],
            'tempat_lahir' => [...$requiredRules, 'string', 'max:150'],
            'tanggal_lahir' => [...$requiredRules, 'date', 'before:today'],
            'alamat_lengkap' => [...$requiredRules, 'string', 'max:300'],
            'kecamatan_id' => [...$requiredRules, 'integer', Rule::exists('kecamatans', 'id')],
            'desa_id' => [
                ...$requiredRules,
                'integer',
                Rule::exists('desas', 'id')->where(fn ($q) => $q->where('kecamatan_id', $kecamatanId)),
            ],
            'pendidikan_id' => [...$requiredRules, 'integer', Rule::exists('pendidikans', 'id')],
            'perusahaan_id' => [...$requiredRules, 'integer', Rule::exists('perusahaans', 'id')],
            'agency_id' => [...$requiredRules, 'integer', Rule::exists('agencies', 'id')],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'NAMA WAJIB DIISI',
            'nik.required' => 'NIK WAJIB DIISI',
            'nik.digits' => 'NIK HARUS 16 DIGIT',
            'nik.unique' => 'NIK SUDAH TERDAFTAR',
            'desa_id.exists' => 'DESA TIDAK VALID UNTUK KECAMATAN YANG DIPILIH',
            'tanggal_lahir.before' => 'TANGGAL LAHIR HARUS SEBELUM HARI INI',
        ];
    }

    public function attributes(): array
    {
        return [
            'nik' => 'Nik',
            'desa_id' => 'Desa',
            'kecamatan_id' => 'Kecamatan',
            'pendidikan_id' => 'Pendidikan',
            'perusahaan_id' => 'Perusahaan',
            'agency_id' => 'Agency',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nik' => preg_replace('/\D/', '', (string) $this->nik),
            'nama' => trim((string) $this->nama),
            'alamat_lengkap' => trim((string) $this->alamat_lengkap),
        ]);
    }
}
