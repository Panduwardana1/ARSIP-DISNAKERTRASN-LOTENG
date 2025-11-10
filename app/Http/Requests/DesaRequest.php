<?php

namespace App\Http\Requests;

use App\Models\Desa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DesaRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     $user = $this->user();

    //     if ($this->isCreate()) {
    //         return $user?->can('create', Desa::class) ?? false;
    //     }

    //     if ($this->isUpdate()) {
    //         return $user?->can('update', $this->route('desa')) ?? false;
    //     }

    //     return $user?->can('viewAny', Desa::class) ?? false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $desa = $this->route('desa');
        $desaId = $desa instanceof Desa ? $desa->id : $desa;

        $uniqueNama = Rule::unique('desas')
            ->where(fn ($query) => $query->where('kecamatan_id', $this->input('kecamatan_id')));

        if ($this->isUpdate() && $desaId) {
            $uniqueNama = $uniqueNama->ignore($desaId);
        }

        return [
            'kecamatan_id' => ['required', 'integer', 'exists:kecamatans,id'],
            'nama' => ['required', 'string', 'max:50', $uniqueNama],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('nama')) {
            $this->merge([
                'nama' => strtoupper((string) $this->input('nama')),
            ]);
        }
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama desa harus diisi',
            'kecamatan_id.required' => 'Kecamatan harus dipilih',
            'kecamatan_id.exists' => 'Kecamatan tidak ditemukan',
            'nama.unique' => 'Nama desa sudah terpakai untuk kecamatan ini',
        ];
    }

    public function isCreate(): bool
    {
        return $this->isMethod('POST');
    }

    public function isUpdate(): bool
    {
        return $this->isMethod('PUT') || $this->isMethod('PATCH');
    }
}
