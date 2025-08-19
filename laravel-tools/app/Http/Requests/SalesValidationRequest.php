<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
        'start_date' => [
            'required',
            'date',
            'before_or_equal:end_date',
        ],

        'end_date' => [
            'required',
            'date',
            'after_or_equal:start_date',
        ],
    ];

    }

    public function messages(): array
{
    return [
        'start_date.required' => 'Please select a start date.',
        'start_date.date' => 'Start date must be a valid date.',
        'start_date.before_or_equal' => 'Start date cannot be later than the end date.',

        'end_date.required' => 'Please select an end date.',
        'end_date.date' => 'End date must be a valid date.',
        'end_date.after_or_equal' => 'End date must be the same or later than the start date.',
    ];
}
}
