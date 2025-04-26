<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'due_date' => 'required|date',
            'client_id' => 'required|exists:clients,id',
            'service_name' => 'required|string',
            'service_description' => 'required|string',
            'service_price' => 'required|numeric',
            // 'invoice_path' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
        ];
    }
}
