<?php

namespace App\Http\Requests\OpenPositionRequest;

use Illuminate\Foundation\Http\FormRequest;

class updateOpenPositionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'location' => ['required', 'string'],
            'description' => ['required', 'string'],
            'employment_type' => ['required', 'string']
        ];
    }
}
