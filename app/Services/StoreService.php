<?php

namespace App\Services;

use App\Models\Store;
use Illuminate\Database\Eloquent\Collection;

class StoreService
{
    /**
     * Get all US states.
     */
    public function getUsStates(): array
    {
        return [
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming',
        ];
    }

    /**
     * Create a new store.
     */
    public function createStore(array $data): Store
    {
        return Store::create($data);
    }

    /**
     * Update an existing store.
     */
    public function updateStore(Store $store, array $data): Store
    {
        $store->update($data);
        return $store->fresh();
    }

    /**
     * Delete a store.
     */
    public function deleteStore(Store $store): bool
    {
        return $store->delete();
    }

    /**
     * Toggle store status.
     */
    public function toggleStoreStatus(Store $store): Store
    {
        $store->update(['is_active' => !$store->is_active]);
        return $store->fresh();
    }

    /**
     * Get active stores.
     */
    public function getActiveStores(): Collection
    {
        return Store::active()->get();
    }

    /**
     * Get primary stores.
     */
    public function getPrimaryStores(): Collection
    {
        return Store::primary()->get();
    }

    /**
     * Get alternate stores.
     */
    public function getAlternateStores(): Collection
    {
        return Store::alternate()->get();
    }
}