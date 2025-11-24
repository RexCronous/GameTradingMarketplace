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
            'description' => ['required', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = ['required', 'image', 'max:5120'];
        } else {
            $rules['image'] = ['nullable', 'image', 'max:5120'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Item name is required.',
            'description.required' => 'Description is required.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
            'price.min' => 'Price must be at least 0.',
            'image.required' => 'An item image is required.',
            'image.image' => 'The file must be an image.',
            'image.max' => 'Image must not exceed 5MB.',
        ];
    }
}

