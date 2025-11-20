<?php

namespace App\Http\Requests;

use App\Models\Author;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('author')?->id;

        return [
            'nama' => ['required', 'string', 'max:100'],
            'nip' => [
                'required',
                'string',
                'min:18',
                'max:20',
                'regex:/^[0-9]+$/',
                Rule::unique('authors', 'nip')->ignore($id),
            ],
            'jabatan' => ['required', 'string', 'max:150'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nama' => str($this->input('nama'))->squish()->toString(),
            'nip' => str($this->input('nip'))->replace(' ', '')->toString(),
            'jabatan' => str($this->input('jabatan'))->squish()->toString(),
        ]);
    }

    public function attributes(): array
    {
        return [
            'nama' => 'Nama',
            'nip' => 'NIP',
            'jabatan' => 'Jabatan',
        ];
    }

    public function messages() : array {
        return [
            'nama' => 'Nama',
            'nip' => 'NIP',
            'jabatan' => 'Jabatan',
        ];
    }
}
