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
            'buyer_id' => ['required', 'exists:users,id'],
            'seller_id' => ['required', 'exists:users,id'],
            'total_price' => ['required', 'numeric', 'min:0'],
            'type' => ['required', 'in:buy,trade'],
            'status' => ['sometimes', 'in:pending,paid,completed,cancelled'],
        ];
    }
}
