<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $storeId = $this->route('store')?->id;

        return [
            'store_name' => ['required', 'string', 'max:255'],
            'phone' => [
                'required',
                'string',
                'regex:/^\(\d{3}\) \d{3}-\d{4}$/',
                Rule::unique('stores')->ignore($storeId)
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('stores')->ignore($storeId)
            ],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'size:2'],
            'zip' => ['required', 'string', 'regex:/^\d{5}(-\d{4})?$/'],
            'designation' => ['required', 'in:primary,alternate'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'store_name.required' => 'Store name is required.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone format must be (555) 123-4567.',
            'phone.unique' => 'This phone number is already registered.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'address.required' => 'Street address is required.',
            'city.required' => 'City is required.',
            'state.required' => 'State is required.',
            'state.size' => 'State must be a valid 2-letter code.',
            'zip.required' => 'ZIP code is required.',
            'zip.regex' => 'ZIP code format must be 12345 or 12345-6789.',
            'designation.required' => 'Store designation is required.',
            'designation.in' => 'Store designation must be either primary or alternate.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Format phone number if it's not already formatted
        if ($this->phone && !preg_match('/^\(\d{3}\) \d{3}-\d{4}$/', $this->phone)) {
            $cleaned = preg_replace('/\D/', '', $this->phone);
            if (strlen($cleaned) === 10) {
                $this->merge([
                    'phone' => sprintf('(%s) %s-%s', 
                        substr($cleaned, 0, 3),
                        substr($cleaned, 3, 3),
                        substr($cleaned, 6, 4)
                    )
                ]);
            }
        }

        // Ensure is_active is boolean
        $this->merge([
            'is_active' => $this->boolean('is_active', true)
        ]);
    }
}