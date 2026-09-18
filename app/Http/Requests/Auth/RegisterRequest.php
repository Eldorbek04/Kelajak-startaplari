<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^\+998[0-9]{9}$/'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'To‘liq ismni kiriting.',
            'phone.required' => 'Telefon raqamni kiriting.',
            'phone.regex' => 'Telefon +998 bilan boshlanib, 9 ta raqamdan iborat bo‘lishi kerak.',
            'password.required' => 'Parolni kiriting.',
            'password.confirmed' => 'Parollar mos kelmaydi.',
        ];
    }
}
