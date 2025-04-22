<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:bills_categories,id',
            'amount' => 'required|numeric|min:0',
            'frequency' => 'required|string|max:255',
            'due_date' => 'required|date',
            'is_recurred' => 'boolean',
            'status' => 'string|in:active,inactive',
            'logo' => 'nullable',
        ];
    }
}
