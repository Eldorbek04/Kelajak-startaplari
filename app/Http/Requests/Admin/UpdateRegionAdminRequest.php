<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateRegionAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user !== null && $user->isSuperAdmin();
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var User $regionAdmin */
        $regionAdmin = $this->route('region_admin');

        return [
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => [
                'required',
                'string',
                'regex:/^\+998[0-9]{9}$/',
                Rule::unique('users', 'phone')->ignore($regionAdmin->id),
            ],
            'password' => ['nullable', 'string', 'confirmed', Password::defaults()],
            'region_id' => ['required', 'integer', 'exists:regions,id'],
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
            'phone.unique' => 'Bu telefon raqam boshqa foydalanuvchida ro‘yxatdan o‘tgan.',
            'password.confirmed' => 'Parollar mos kelmaydi.',
            'region_id.required' => 'Viloyatni tanlang.',
            'region_id.exists' => 'Tanlangan viloyat noto‘g‘ri.',
        ];
    }
}
