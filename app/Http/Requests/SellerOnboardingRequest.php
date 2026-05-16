<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerOnboardingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'store_name' => ['required', 'string', 'max:120', 'unique:sellers,store_name'],
            'business_email' => ['nullable', 'email'],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
