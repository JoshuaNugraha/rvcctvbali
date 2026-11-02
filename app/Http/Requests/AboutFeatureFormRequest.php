<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AboutFeatureFormRequest extends FormRequest
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
            'about_us_id' => ['nullable', 'exists:about_us,id'],
            'sequence' => ['nullable', 'integer', 'min:1', 'max:99'],
            'title_eng' => ['required', 'string', 'max:255'],
            'title_ina' => ['required', 'string', 'max:255'],
            'description_eng' => ['required', 'string'],
            'description_ina' => ['required', 'string'],
        ];
    }
}
