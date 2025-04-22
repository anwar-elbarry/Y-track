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
            'name' => 'string|max:255',
            'category_id' => 'exists:bills_categories,id',
            'amount' => 'numeric|min:0',
            'frequency' => 'string|max:255',
            'due_date' => 'date',
            'is_recurred' => 'boolean',
            'status' => 'string|in:paid,unpaid',
            'logo' => 'nullable',
        ];
    }
}
