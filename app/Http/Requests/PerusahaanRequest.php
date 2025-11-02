<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PerusahaanRequest extends FormRequest
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
        $routeParam = $this->route('perusahaan');
        $perusahaanId = $routeParam instanceof \App\Models\Perusahaan ? $routeParam->id : $routeParam;
        $isUpdate = $this->isMethod('patch') || $this->isMethod('put');
        $requiredRules = $isUpdate ? ['sometimes', 'required'] : ['required'];

        $namaUniquePerAgency = Rule::unique('perusahaans', 'nama')
            ->ignore($perusahaanId)
            ->where(fn ($query) => $query->where('agency_id', $this->input('agency_id')));

        $emailUnique = Rule::unique('perusahaans', 'email')->ignore($perusahaanId);

        $gambarRules = [
            $isUpdate ? 'nullable' : 'required',
            'image',
            'mimes:jpg,jpeg,png',
            'max:2048',
            'dimensions:min_width=100,min_height=100',
        ];

        return [
            'agency_id' => array_merge($requiredRules, ['integer', Rule::exists('agencies', 'id')]),
            'nama' => array_merge($requiredRules, ['string', 'max:100', $namaUniquePerAgency]),
            'pimpinan' => ['nullable', 'string', 'max:100'],
            'email' => array_merge($requiredRules, ['email', 'max:100', $emailUnique]),
            'alamat' => ['nullable', 'string'],
            'gambar' => $gambarRules,
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama P3MI wajib diisi.',
            'nama.unique' => 'Nama perusahaan sudah terdaftar pada agency ini.',
            'email.required' => 'Email P3MI wajib diisi.',
            'email.unique' => 'Alamat email sudah digunakan.',
            'gambar.required' => 'Logo perusahaan wajib diunggah.',
            'gambar.image' => 'Berkas gambar harus berupa foto.',
            'gambar.mimes' => 'Format gambar harus JPG atau PNG.',
            'gambar.max' => 'Ukuran gambar maksimal 2 MB.',
            'gambar.dimensions' => 'Resolusi gambar minimal 100x100 piksel.',
            'agency_id.required' => 'Agency wajib dipilih.',
            'agency_id.exists' => 'Agency tidak ditemukan.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'Nama Perusahaan',
            'pimpinan' => 'Nama Pimpinan/Petugas',
            'email' => 'Email',
            'alamat' => 'Alamat',
            'gambar' => 'Logo',
            'agency_id' => 'Agency',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama' => trim((string) $this->nama),
            'pimpinan' => $this->filled('pimpinan') ? trim((string) $this->pimpinan) : null,
            'email' => $this->filled('email') ? mb_strtolower(trim((string) $this->email)) : null,
            'alamat' => $this->filled('alamat')
                ? preg_replace('/\s+/u', ' ', trim((string) $this->alamat))
                : null,
        ]);
    }
}
