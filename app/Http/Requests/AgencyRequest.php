<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgencyRequest extends FormRequest
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
        $routeParam = $this->route('agency');
        $agencyId = $routeParam instanceof \App\Models\Agency ? $routeParam->id : $routeParam;
        $isUpdate = $this->isMethod('patch') || $this->isMethod('put');
        $requiredRules = $isUpdate ? ['sometimes', 'required'] : ['required'];

        $namaUnique = Rule::unique('agencies', 'nama')->ignore($agencyId);

        return [
            'nama' => array_merge($requiredRules, ['string', 'max:150', $namaUnique]),
            'country' => array_merge($requiredRules, ['string', 'max:120']),
            'kota' => array_merge($requiredRules, ['string', 'max:120']),
            'lowongan' => array_merge($requiredRules, ['string', 'max:255']),
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama agency wajib diisi.',
            'nama.unique' => 'Nama agency sudah terdaftar.',
            'country.required' => 'Negara tujuan wajib diisi.',
            'kota.required' => 'Kota tujuan wajib diisi.',
            'lowongan.required' => 'Informasi lowongan wajib diisi.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'Nama Agency',
            'country' => 'Negara Tujuan',
            'kota' => 'Kota Penempatan',
            'lowongan' => 'Informasi Lowongan',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama' => trim((string) $this->nama),
            'country' => $this->filled('country') ? trim((string) $this->country) : null,
            'kota' => $this->filled('kota') ? trim((string) $this->kota) : null,
            'lowongan' => $this->filled('lowongan')
                ? preg_replace('/\s+/u', ' ', trim((string) $this->lowongan))
                : null,
        ]);
    }
}
