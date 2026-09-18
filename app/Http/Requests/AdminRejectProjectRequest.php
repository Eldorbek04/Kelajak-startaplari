<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\ProjectSubmission;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AdminRejectProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        $submission = $this->route('projectSubmission');

        return $submission instanceof ProjectSubmission
            && $this->user() !== null
            && $this->user()->can('update', $submission);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rejection_reason' => ['required', 'string', 'min:10', 'max:2000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'rejection_reason' => 'bekor qilish izohi',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'rejection_reason.required' => 'Arizani bekor qilish uchun nima uchun bekor qilinayotganini yozishingiz kerak.',
            'rejection_reason.min' => 'Bekor qilish sababini batafsilroq yozing (kamida :min belgi).',
            'rejection_reason.max' => 'Izoh :max belgidan oshmasligi kerak.',
        ];
    }
}
