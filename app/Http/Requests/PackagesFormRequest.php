<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PackagesFormRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'sequence' => ['nullable', 'integer', 'min:0'],
            'channel_id' => ['nullable', 'exists:channels,id'],
            'brands' => ['nullable', 'array'],
            'brands.*' => ['string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'cameras' => ['nullable', 'string', 'max:255'],
            'recorder_unit' => ['nullable', 'string', 'max:255'],
            'storage' => ['nullable', 'string', 'max:255'],
            'power_connectors' => ['nullable', 'string', 'max:255'],
            'cable' => ['nullable', 'string', 'max:255'],
            'service' => ['nullable', 'string', 'max:255'],
            'description_eng' => ['nullable', 'string'],
            'description_ina' => ['nullable', 'string'],
        ];
    }
}
