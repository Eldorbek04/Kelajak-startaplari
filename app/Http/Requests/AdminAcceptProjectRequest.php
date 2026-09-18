<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\ProjectSubmission;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AdminAcceptProjectRequest extends FormRequest
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
            'region_date' => ['required', 'date'],
            'region_time' => ['required', 'string', 'max:32'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'region_date' => 'viloyat sanasi',
            'region_time' => 'viloyat vaqti',
        ];
    }
}
