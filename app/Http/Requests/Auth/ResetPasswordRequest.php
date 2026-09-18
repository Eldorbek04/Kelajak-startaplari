<?php

namespace App\Http\Requests\Auth;

use App\Support\AuthSessionKeys;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Validator;

class ResetPasswordRequest extends FormRequest
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
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if (! $this->session()->get(AuthSessionKeys::PASSWORD_RESET_VERIFIED, false)) {
                $validator->errors()->add(
                    'password',
                    __('Please verify your phone with the code we sent before setting a new password.'),
                );
            }
        });
    }
}
