<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['sometimes', 'in:available,reserved,sold,traded'],
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = ['required', 'image', 'max:5120'];
        } else {
            $rules['image'] = ['nullable', 'image', 'max:5120'];
        }

        return $rules;
    }
}
