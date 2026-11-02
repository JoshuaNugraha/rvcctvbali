<?php

namespace App\Http\Requests;

use App\Models\Channel;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChannelsFormRequest extends FormRequest
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
        $channelRouteParam = $this->route('channel');
        $channelId = $channelRouteParam instanceof Channel ? $channelRouteParam->id : $channelRouteParam;

        return [
            'total_channels' => [
                'required',
                'integer',
                'min:1',
                'max:128',
                Rule::unique('channels', 'total_channels')->ignore($channelId),
            ],
        ];
    }
}
