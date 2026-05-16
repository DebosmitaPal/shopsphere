<?php

namespace App\Http\Requests;

use App\Rules\PositiveStock;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'seller';
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'min:10'],
            'price' => ['required', 'numeric', 'min:1'],
            'stock_quantity' => ['required', new PositiveStock],
            'image' => ['nullable', 'image', 'max:2048'],
            'status' => ['required', 'in:active,draft,inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'price.numeric' => 'Product price must be numeric.',
            'description.min' => 'Please add a clearer product description.',
        ];
    }
}
