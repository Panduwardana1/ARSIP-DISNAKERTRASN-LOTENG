<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return [
            'identifier' => [
                'required',
                'string',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $input = trim((string) $value);
                    $isEmail = filter_var($input, FILTER_VALIDATE_EMAIL);
                    $isNip = preg_match('/^[0-9]{18}$/', $input);

                    if (!$isEmail && !$isNip) {
                        $fail('Masukkan NIP 18 digit atau email yang valid.');
                    }
                },
            ],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    protected function prepareForValidation() : void {
        $this->merge([
            'identifier' => trim((string) $this->input('identifier')),
            'password' => trim($this->input('password')),
        ]);
    }

    public function messages(): array {
        return [
            'identifier.required' => 'NIP atau Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ];
    }
}
