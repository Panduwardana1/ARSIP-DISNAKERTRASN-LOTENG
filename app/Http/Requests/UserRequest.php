<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('manage_users') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user')?->id ?? null;
        $passwordRules = $userId
            ? ['nullable', 'string', 'min:6', 'confirmed']
            : ['required', 'string', 'min:6', 'confirmed'];

        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'nip' => ['required', 'digits:18', Rule::unique('users', 'nip')->ignore($userId)],
            'role' => ['required', 'string', Rule::exists('roles', 'name')],
            'is_active' => ['required', Rule::in(['active', 'nonactive'])],
            'password' => $passwordRules,
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->input('name')),
            'email' => trim((string) $this->input('email')),
            'nip' => preg_replace('/\D/', '', (string) $this->input('nip')),
            'role' => trim((string) $this->input('role')),
            'is_active' => $this->input('is_active', 'active'),
        ]);
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.digits' => 'NIP harus 18 digit.',
            'role.required' => 'Role wajib dipilih.',
            'role.exists' => 'Role tidak ditemukan.',
            'is_active.in' => 'Status akun tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ];
    }
}
