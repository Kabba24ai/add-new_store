<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

class SettingsService
{
    /**
     * Get settings configuration structure.
     */
    public function getSettingsConfig(): array
    {
        return [
            'admin' => [
                'title' => 'Admin Control',
                'description' => 'Administrative settings and security configuration',
                'icon' => 'shield-check',
                'fields' => [
                    'master_passcode' => [
                        'label' => 'Master Passcode',
                        'type' => 'password',
                        'encrypted' => true,
                        'description' => 'Must be encrypted. Required to access/edit encrypted Master Passcode.',
                        'required' => false,
                    ],
                ]
            ],
            'contact' => [
                'title' => 'Contact Us - Website Contact Page',
                'description' => 'Contact information displayed on your website',
                'icon' => 'phone',
                'fields' => [
                    'contact_phone' => [
                        'label' => 'Phone',
                        'type' => 'tel',
                        'description' => 'Use defined phone format for USA (xxx) xxx-xxxx',
                        'required' => true,
                    ],
                    'contact_email_general' => [
                        'label' => 'Email - General',
                        'type' => 'email',
                        'required' => true,
                    ],
                    'contact_email_sales' => [
                        'label' => 'Email - Sales Inquiry',
                        'type' => 'email',
                        'required' => true,
                    ],
                    'contact_email_complaints' => [
                        'label' => 'Email - Complaints',
                        'type' => 'email',
                        'required' => true,
                    ],
                    'contact_email_feedback' => [
                        'label' => 'Email - Feedback',
                        'type' => 'email',
                        'required' => true,
                    ],
                    'contact_note' => [
                        'label' => 'Note to Other People',
                        'type' => 'textarea',
                        'description' => 'Store locations/addresses that appear on the Contact Us page are in Stores Settings (make the Stores Settings a hyperlink to the Stores Settings page - add this as a note for the programming team)',
                        'required' => false,
                    ],
                ]
            ],
            'payment' => [
                'title' => 'Payment Integration',
                'description' => 'Payment gateway and API configuration',
                'icon' => 'credit-card',
                'fields' => [
                    'payment_gateway' => [
                        'label' => 'Payment Gateway',
                        'type' => 'text',
                        'required' => true,
                    ],
                    'payment_api_public_key' => [
                        'label' => 'Payment API - Public Key',
                        'type' => 'text',
                        'required' => true,
                    ],
                    'payment_api_key' => [
                        'label' => 'Payment API Key',
                        'type' => 'text',
                        'encrypted' => true,
                        'required' => true,
                    ],
                    'payment_api_secret_key' => [
                        'label' => 'Payment API Secret Key',
                        'type' => 'password',
                        'encrypted' => true,
                        'description' => 'Must be encrypted',
                        'required' => true,
                    ],
                    'payment_test_mode' => [
                        'label' => 'Payment Test Mode',
                        'type' => 'radio',
                        'options' => ['Yes', 'No'],
                        'description' => 'Yes or No (drop down or radio buttons)',
                        'required' => true,
                    ],
                ]
            ],
            'product' => [
                'title' => 'Product Settings',
                'description' => 'Sales tax, delivery ranges, and product configuration',
                'icon' => 'cog',
                'fields' => [
                    'sales_tax' => [
                        'label' => 'Sales Tax',
                        'type' => 'number',
                        'step' => '0.01',
                        'min' => '0',
                        'max' => '100',
                        'suffix' => '%',
                        'required' => true,
                    ],
                    'standard_delivery_range' => [
                        'label' => 'Standard Delivery Range - Up To',
                        'type' => 'number',
                        'step' => '0.1',
                        'min' => '0',
                        'description' => 'Numerical distance number',
                        'required' => true,
                    ],
                    'extended_delivery_range' => [
                        'label' => 'Extended Delivery Range - Up To',
                        'type' => 'number',
                        'step' => '0.1',
                        'min' => '0',
                        'description' => 'Numerical distance number',
                        'required' => true,
                    ],
                    'include_extended_range' => [
                        'label' => 'Include Extended Range Option',
                        'type' => 'checkbox',
                        'required' => false,
                    ],
                    'distance_units' => [
                        'label' => 'Distance Units',
                        'type' => 'select',
                        'options' => ['miles' => 'Miles', 'kilometers' => 'Kilometers'],
                        'required' => true,
                    ],
                ]
            ]
        ];
    }

    /**
     * Get settings by section.
     */
    public function getSettingsBySection(string $section): array
    {
        return Setting::where('section', $section)->pluck('value', 'key')->toArray();
    }

    /**
     * Update settings for a section.
     */
    public function updateSettings(array $data): void
    {
        $section = $data['section'];
        $config = $this->getSettingsConfig()[$section] ?? [];
        
        unset($data['section']);

        foreach ($data as $key => $value) {
            if ($key === 'master_passcode_confirmation') {
                continue;
            }

            $fieldConfig = $config['fields'][$key] ?? [];
            $isEncrypted = $fieldConfig['encrypted'] ?? false;
            $type = $fieldConfig['type'] ?? 'text';

            // Hash master passcode
            if ($key === 'master_passcode' && $value) {
                $value = Hash::make($value);
                $isEncrypted = false; // Already hashed, don't encrypt again
            }

            // Skip empty passwords
            if ($type === 'password' && empty($value)) {
                continue;
            }

            Setting::set($key, $value, $section, $type, $isEncrypted);
        }

        Setting::clearCache();
    }

    /**
     * Verify master passcode.
     */
    public function verifyMasterPasscode(string $passcode): bool
    {
        $hashedPasscode = Setting::get('master_passcode');
        
        if (!$hashedPasscode) {
            return false;
        }

        return Hash::check($passcode, $hashedPasscode);
    }

    /**
     * Check if master passcode verification is required and valid.
     */
    public function requiresPasscodeVerification(): bool
    {
        if (!session('master_passcode_verified')) {
            return true;
        }

        $verifiedAt = session('passcode_verified_at');
        if (!$verifiedAt || now()->diffInMinutes($verifiedAt) > 30) {
            session()->forget(['master_passcode_verified', 'passcode_verified_at']);
            return true;
        }

        return false;
    }
}