<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Models\Store;
use App\Services\StoreService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StoreController extends Controller
{
    protected StoreService $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    /**
     * Display a listing of stores.
     */
    public function index(Request $request): View
    {
        $stores = Store::query()
            ->when($request->search, function ($query, $search) {
                $query->where('store_name', 'like', "%{$search}%")
                      ->orWhere('city', 'like', "%{$search}%")
                      ->orWhere('state', 'like', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                $query->where('is_active', $status === 'active');
            })
            ->when($request->designation, function ($query, $designation) {
                $query->where('designation', $designation);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new store.
     */
    public function create(): View
    {
        $states = $this->storeService->getUsStates();
        return view('stores.create', compact('states'));
    }

    /**
     * Store a newly created store in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $store = $this->storeService->createStore($request->validated());
            
            return redirect()
                ->route('stores.show', $store)
                ->with('success', 'Store created successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create store. Please try again.');
        }
    }

    /**
     * Display the specified store.
     */
    public function show(Store $store): View
    {
        return view('stores.show', compact('store'));
    }

    /**
     * Show the form for editing the specified store.
     */
    public function edit(Store $store): View
    {
        $states = $this->storeService->getUsStates();
        return view('stores.edit', compact('store', 'states'));
    }

    /**
     * Update the specified store in storage.
     */
    public function update(StoreRequest $request, Store $store): RedirectResponse
    {
        try {
            $this->storeService->updateStore($store, $request->validated());
            
            return redirect()
                ->route('stores.show', $store)
                ->with('success', 'Store updated successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update store. Please try again.');
        }
    }

    /**
     * Remove the specified store from storage.
     */
    public function destroy(Store $store): RedirectResponse
    {
        try {
            $this->storeService->deleteStore($store);
            
            return redirect()
                ->route('stores.index')
                ->with('success', 'Store deleted successfully!');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete store. Please try again.');
        }
    }

    /**
     * Toggle store status.
     */
    public function toggleStatus(Store $store): RedirectResponse
    {
        try {
            $this->storeService->toggleStoreStatus($store);
            
            $status = $store->is_active ? 'activated' : 'deactivated';
            return back()->with('success', "Store {$status} successfully!");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update store status.');
        }
    }
}