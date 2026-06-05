<?php

namespace App\Http\Requests\Admin\Section;

use App\DTOs\Section\SectionData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sectionId = $this->route('section')?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sections', 'name')->ignore($sectionId),
            ],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم القسم مطلوب.',
            'name.unique' => 'اسم القسم مستخدم مسبقاً.',
            'image.image' => 'يجب أن يكون الملف صورة.',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت.',
        ];
    }

    public function toDto(): SectionData
    {
        return new SectionData(
            name: $this->string('name')->toString(),
            image: $this->file('image'),
        );
    }
}
