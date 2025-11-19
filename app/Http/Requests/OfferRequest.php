<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'item_id' => ['required', 'exists:items,id'],
            'cash_amount' => ['nullable', 'numeric', 'min:0'],
            'offered_item_ids' => ['nullable', 'array'],
            'offered_item_ids.*' => ['integer', 'exists:items,id'],
        ];
    }
}
