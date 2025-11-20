<?php

namespace App\Http\Requests;

use App\Models\Perusahaan;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PerusahaanRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
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
        $id = $this->route('perusahaan')?->id;

        $emailRule = Rule::unique('perusahaans', 'email')
            ->where(fn ($query) => $query->whereNull('deleted_at'));

        if ($id) {
            $emailRule->ignore($id);
        }

        return [
            'nama' => ['required', 'string', 'max:100', Rule::unique('perusahaans', 'nama')->ignore($id)],
            'pimpinan' => ['nullable', 'string', 'max:100'],
            'email' => [
                'nullable',
                'email',
                'max:100',
                $emailRule,
            ],
            'alamat' => ['nullable', 'string'],
            'gambar' => ['nullable', 'mimes:png,jpg,jpeg', 'image', 'max:2048'],
        ];
    }

    public function messages() : array {
        return [
            'nama.required' => 'Nama perusahaan wajib diisi.',
            'nama.unique' => 'Nama sudah digunakan.',
            'nama.max' => 'Nama perusahaan terlalu panjang.',
            'email.email' => 'Format email perusahaan tidak valid.',
            'email.unique' => 'Email perusahaan sudah terdaftar.',
            'gambar.image' => 'File logo harus berupa gambar.',
            'gambar.mimes' => 'Format gambar yang diperbolehkan: png, jpg, atau jpeg.',
            'gambar.max' => 'Ukuran file logo maksimal 2 MB.',
        ];
    }

    protected function prepareForValidation()
    {
        $nama = $this->input('nama');
        $email = $this->input('email');

        $this->merge([
            'nama' => $nama ? trim((string) $nama) : null,
            'email' => $email ? Str::lower(trim((string) $email)) : null,
        ]);
    }
}
