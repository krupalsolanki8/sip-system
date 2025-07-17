<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSipRequest extends FormRequest
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
            'amount' => ['required', 'numeric', 'min:1'],
            'frequency' => ['required', 'in:daily,monthly'],
            'sip_day' => ['nullable', 'required_if:frequency,monthly', 'integer', 'between:1,30'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            // 'status' => ['in:active,inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'sip_day.required_if' => 'The Sip Date field is required.',
        ];
    }
}
