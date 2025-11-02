<?php

namespace App\Http\Requests;

use App\Models\Desa;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DesaRequest extends FormRequest
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
        $routeParam = $this->route('desa');
        $desa = $routeParam instanceof Desa ? $routeParam : Desa::find($routeParam);
        $id = $desa?->id ?? $routeParam;

        $requireRules = ($this->isMethod('patch') || $this->isMethod('put'))
            ? ['sometimes', 'required']
            : ['required'];

        $kecamatanId = $this->input('kecamatan_id', $desa?->kecamatan_id);
        $tipe = $this->input('tipe', $desa?->tipe);

        $namaUnik = Rule::unique('desas', 'nama')
            ->where(function ($q) use ($kecamatanId, $tipe) {
                $q->where('kecamatan_id', $kecamatanId)
                    ->where('tipe', $tipe);
            })
            ->ignore($id);

        return [
            'kecamatan_id' => [...$requireRules, 'integer', Rule::exists('kecamatans', 'id')],
            'nama' => [...$requireRules, 'string', 'max:100', $namaUnik],
            'tipe' => [...$requireRules, Rule::in(['desa', 'kelurahan'])],
        ];
    }

    public function messages(): array
    {
        return [
            'kecamatan_id.required' => 'Kecamatan wajib dipilih.',
            'kecamatan_id.exists' => 'Kecamatan yang dipilih tidak ditemukan.',
            'nama.required' => 'Nama desa/kelurahan wajib diisi.',
            'nama.unique' => 'Nama sudah digunakan dalam kecamatan tersebut.',
            'tipe.required' => 'Tipe wilayah wajib dipilih.',
            'tipe.in' => 'Tipe harus salah satu dari desa atau kelurahan.',
        ];
    }

    public function attributes(): array
    {
        return [
            'kecamatan_id' => 'Kecamatan',
            'nama' => 'Nama',
            'tipe' => 'Tipe',
        ];
    }

    protected function prepareForValidation(): void
    {
        $nama = preg_replace('/\s+/u', ' ', trim((string) $this->nama));
        $tipe = $this->tipe ? strtolower(trim((string) $this->tipe)) : $this->tipe;

        $this->merge([
            'nama' => $nama,
            'tipe' => $tipe,
        ]);
    }
}
