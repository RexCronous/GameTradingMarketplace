<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'required|in:buy,trade',
            'offer_item_id' => 'nullable|exists:items,id|required_if:type,trade',
            'offer_amount' => 'nullable|numeric|min:0|required_if:type,buy',
            'notes' => 'nullable|string|max:500',
        ];
    }
}
