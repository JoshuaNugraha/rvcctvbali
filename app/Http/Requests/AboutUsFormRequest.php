<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AboutUsFormRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'sub_title' => ['nullable', 'string', 'max:255'],
            'sub_title_eng' => ['nullable', 'string', 'max:255'],
            'sub_title_ina' => ['nullable', 'string', 'max:255'],
            'headline_eng' => ['nullable', 'string', 'max:255'],
            'headline_ina' => ['nullable', 'string', 'max:255'],
            'heading_eng' => ['nullable', 'string', 'max:255'],
            'heading_ina' => ['nullable', 'string', 'max:255'],
            'description_eng' => ['nullable', 'string'],
            'description_ina' => ['nullable', 'string'],
            'picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'features' => ['nullable', 'array'],
            'features.*.title_eng' => ['nullable', 'string', 'max:255'],
            'features.*.title_ina' => ['nullable', 'string', 'max:255'],
            'features.*.description_eng' => ['nullable', 'string'],
            'features.*.description_ina' => ['nullable', 'string'],
            'features.*.sequence' => ['nullable', 'integer'],
        ];
    }
}
