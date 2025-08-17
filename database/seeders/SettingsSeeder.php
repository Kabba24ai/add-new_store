<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Admin Control
            [
                'section' => 'admin',
                'key' => 'master_passcode',
                'value' => Hash::make('admin123'),
                'type' => 'password',
                'is_encrypted' => false,
                'description' => 'Master passcode for admin access',
            ],

            // Contact Us
            [
                'section' => 'contact',
                'key' => 'contact_phone',
                'value' => '(555) 123-4567',
                'type' => 'tel',
                'is_encrypted' => false,
                'description' => 'Main contact phone number',
            ],
            [
                'section' => 'contact',
                'key' => 'contact_email_general',
                'value' => 'info@company.com',
                'type' => 'email',
                'is_encrypted' => false,
                'description' => 'General inquiries email',
            ],
            [
                'section' => 'contact',
                'key' => 'contact_email_sales',
                'value' => 'sales@company.com',
                'type' => 'email',
                'is_encrypted' => false,
                'description' => 'Sales inquiries email',
            ],
            [
                'section' => 'contact',
                'key' => 'contact_email_complaints',
                'value' => 'complaints@company.com',
                'type' => 'email',
                'is_encrypted' => false,
                'description' => 'Complaints email',
            ],
            [
                'section' => 'contact',
                'key' => 'contact_email_feedback',
                'value' => 'feedback@company.com',
                'type' => 'email',
                'is_encrypted' => false,
                'description' => 'Feedback email',
            ],
            [
                'section' => 'contact',
                'key' => 'contact_note',
                'value' => 'Store locations and addresses are managed in the Stores Settings section.',
                'type' => 'textarea',
                'is_encrypted' => false,
                'description' => 'Note about store locations',
            ],

            // Payment Integration
            [
                'section' => 'payment',
                'key' => 'payment_gateway',
                'value' => 'Stripe',
                'type' => 'text',
                'is_encrypted' => false,
                'description' => 'Payment gateway provider',
            ],
            [
                'section' => 'payment',
                'key' => 'payment_api_public_key',
                'value' => 'pk_test_example_public_key',
                'type' => 'text',
                'is_encrypted' => false,
                'description' => 'Payment API public key',
            ],
            [
                'section' => 'payment',
                'key' => 'payment_api_key',
                'value' => 'sk_test_example_api_key',
                'type' => 'text',
                'is_encrypted' => true,
                'description' => 'Payment API key (encrypted)',
            ],
            [
                'section' => 'payment',
                'key' => 'payment_api_secret_key',
                'value' => 'secret_key_example',
                'type' => 'password',
                'is_encrypted' => true,
                'description' => 'Payment API secret key (encrypted)',
            ],
            [
                'section' => 'payment',
                'key' => 'payment_test_mode',
                'value' => '1',
                'type' => 'radio',
                'is_encrypted' => false,
                'description' => 'Payment test mode enabled',
            ],

            // Product Settings
            [
                'section' => 'product',
                'key' => 'sales_tax',
                'value' => '8.25',
                'type' => 'number',
                'is_encrypted' => false,
                'description' => 'Sales tax percentage',
            ],
            [
                'section' => 'product',
                'key' => 'standard_delivery_range',
                'value' => '25',
                'type' => 'number',
                'is_encrypted' => false,
                'description' => 'Standard delivery range in miles/km',
            ],
            [
                'section' => 'product',
                'key' => 'extended_delivery_range',
                'value' => '50',
                'type' => 'number',
                'is_encrypted' => false,
                'description' => 'Extended delivery range in miles/km',
            ],
            [
                'section' => 'product',
                'key' => 'include_extended_range',
                'value' => '1',
                'type' => 'checkbox',
                'is_encrypted' => false,
                'description' => 'Include extended delivery range option',
            ],
            [
                'section' => 'product',
                'key' => 'distance_units',
                'value' => 'miles',
                'type' => 'select',
                'is_encrypted' => false,
                'description' => 'Distance measurement units',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}