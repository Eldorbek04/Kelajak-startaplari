<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectSubmitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $budget = $this->input('required_budget');
        if ($budget === null || $budget === '') {
            return;
        }

        $digits = preg_replace('/\D+/', '', (string) $budget);
        if ($digits === '') {
            $this->merge(['required_budget' => null]);

            return;
        }

        $this->merge(['required_budget' => (int) $digits]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $regionId = $this->input('region_id');

        return [
            'project_title' => ['required', 'string', 'max:255'],
            'document' => ['required', 'file', 'max:20480', 'mimes:pdf,ppt,pptx'],
            'required_budget' => ['required', 'integer', 'min:0', 'max:999999999999'],
            'region_id' => ['required', 'integer', 'exists:regions,id'],
            'district_id' => [
                'required',
                'integer',
                'exists:districts,id',
                Rule::exists('districts', 'id')->where('region_id', $regionId),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'project_title.required' => 'Loyiha nomini kiriting.',
            'project_title.max' => 'Loyiha nomi juda uzun.',
            'document.required' => 'PDF yoki PPT faylni yuklang.',
            'document.max' => 'Fayl hajmi 20 MB dan oshmasligi kerak.',
            'document.mimes' => 'Faqat PDF yoki PowerPoint (PPT, PPTX) fayllar qabul qilinadi.',
            'required_budget.required' => 'Byudjet miqdorini kiriting.',
            'required_budget.integer' => 'Byudjet butun son bo‘lishi kerak.',
            'required_budget.min' => 'Byudjet manfiy bo‘lmasligi kerak.',
            'required_budget.max' => 'Byudjet juda katta.',
            'region_id.required' => 'Viloyatni tanlang.',
            'region_id.exists' => 'Tanlangan viloyat noto‘g‘ri.',
            'district_id.required' => 'Tumanni tanlang.',
            'district_id.exists' => 'Tanlangan tuman ushbu viloyatga tegishli emas.',
        ];
    }
}
