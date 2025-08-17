<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a few sample stores
        Store::factory()->primary()->active()->create([
            'store_name' => 'Downtown Electronics',
            'phone' => '(555) 123-4567',
            'email' => 'downtown@electronics.com',
            'address' => '123 Main Street',
            'city' => 'San Francisco',
            'state' => 'CA',
            'zip' => '94102',
        ]);

        Store::factory()->alternate()->active()->create([
            'store_name' => 'Westside Rentals',
            'phone' => '(555) 987-6543',
            'email' => 'westside@rentals.com',
            'address' => '456 Oak Avenue',
            'city' => 'Los Angeles',
            'state' => 'CA',
            'zip' => '90210',
        ]);

        Store::factory()->alternate()->inactive()->create([
            'store_name' => 'Eastside Equipment',
            'phone' => '(555) 456-7890',
            'email' => 'eastside@equipment.com',
            'address' => '789 Pine Street',
            'city' => 'New York',
            'state' => 'NY',
            'zip' => '10001',
        ]);

        // Create additional random stores
        Store::factory(7)->create();
    }
}