<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
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
        $section = $this->get('section', 'admin');
        
        $rules = [
            'section' => 'required|string|in:admin,contact,payment,product',
        ];

        switch ($section) {
            case 'admin':
                $rules = array_merge($rules, [
                    'master_passcode' => 'nullable|string|min:8',
                    'master_passcode_confirmation' => 'nullable|string|same:master_passcode',
                ]);
                break;

            case 'contact':
                $rules = array_merge($rules, [
                    'contact_phone' => 'required|string|regex:/^\(\d{3}\) \d{3}-\d{4}$/',
                    'contact_email_general' => 'required|email|max:255',
                    'contact_email_sales' => 'required|email|max:255',
                    'contact_email_complaints' => 'required|email|max:255',
                    'contact_email_feedback' => 'required|email|max:255',
                    'contact_note' => 'nullable|string|max:1000',
                ]);
                break;

            case 'payment':
                $rules = array_merge($rules, [
                    'payment_gateway' => 'required|string|max:255',
                    'payment_api_public_key' => 'required|string|max:500',
                    'payment_api_key' => 'required|string|max:500',
                    'payment_api_secret_key' => 'required|string|max:500',
                    'payment_test_mode' => 'boolean',
                ]);
                break;

            case 'product':
                $rules = array_merge($rules, [
                    'sales_tax' => 'required|numeric|min:0|max:100',
                    'standard_delivery_range' => 'required|numeric|min:0',
                    'extended_delivery_range' => 'required|numeric|min:0',
                    'include_extended_range' => 'boolean',
                    'distance_units' => 'required|string|in:miles,kilometers',
                ]);
                break;
        }

        return $rules;
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'master_passcode.min' => 'Master passcode must be at least 8 characters.',
            'master_passcode_confirmation.same' => 'Passcode confirmation does not match.',
            'contact_phone.regex' => 'Phone format must be (555) 123-4567.',
            'contact_email_general.email' => 'Please enter a valid general email address.',
            'contact_email_sales.email' => 'Please enter a valid sales email address.',
            'contact_email_complaints.email' => 'Please enter a valid complaints email address.',
            'contact_email_feedback.email' => 'Please enter a valid feedback email address.',
            'payment_gateway.required' => 'Payment gateway is required.',
            'payment_api_public_key.required' => 'Payment API public key is required.',
            'payment_api_key.required' => 'Payment API key is required.',
            'payment_api_secret_key.required' => 'Payment API secret key is required.',
            'sales_tax.required' => 'Sales tax percentage is required.',
            'sales_tax.numeric' => 'Sales tax must be a valid number.',
            'sales_tax.max' => 'Sales tax cannot exceed 100%.',
            'standard_delivery_range.required' => 'Standard delivery range is required.',
            'extended_delivery_range.required' => 'Extended delivery range is required.',
            'distance_units.in' => 'Distance units must be either miles or kilometers.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Format phone number if it's not already formatted
        if ($this->contact_phone && !preg_match('/^\(\d{3}\) \d{3}-\d{4}$/', $this->contact_phone)) {
            $cleaned = preg_replace('/\D/', '', $this->contact_phone);
            if (strlen($cleaned) === 10) {
                $this->merge([
                    'contact_phone' => sprintf('(%s) %s-%s', 
                        substr($cleaned, 0, 3),
                        substr($cleaned, 3, 3),
                        substr($cleaned, 6, 4)
                    )
                ]);
            }
        }

        // Ensure boolean fields are properly set
        $this->merge([
            'payment_test_mode' => $this->boolean('payment_test_mode', false),
            'include_extended_range' => $this->boolean('include_extended_range', false),
        ]);
    }
}