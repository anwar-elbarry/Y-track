<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomeRequest extends FormRequest
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
            'client_id' => 'nullable|exists:clients,id',
            'amount' => 'numeric|min:0',
            'source' => 'nullable|string|max:255',
            'frequency' => 'in:one-time,daily,weekly,monthly,yearly',
            'status' => 'in:active,inactive',
            'start_at' => 'date',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'amount.min' => 'Income amount must be a positive number.',
            'frequency.in' => 'Invalid frequency selected.',
        ];
    }
}
