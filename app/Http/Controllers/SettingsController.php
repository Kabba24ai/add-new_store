<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsRequest;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    protected SettingsService $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * Display the settings page.
     */
    public function index(Request $request): View
    {
        $activeSection = $request->get('section', 'admin');
        
        $sections = [
            'admin' => 'Admin Control',
            'contact' => 'Contact Us',
            'payment' => 'Payment Integration',
            'product' => 'Product Settings'
        ];

        $settings = $this->settingsService->getSettingsBySection($activeSection);
        $settingsConfig = $this->settingsService->getSettingsConfig();

        return view('settings.index', compact('sections', 'activeSection', 'settings', 'settingsConfig'));
    }

    /**
     * Update settings.
     */
    public function update(SettingsRequest $request): RedirectResponse
    {
        try {
            $this->settingsService->updateSettings($request->validated());
            
            return redirect()
                ->route('settings.index', ['section' => $request->get('section', 'admin')])
                ->with('success', 'Settings updated successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update settings. Please try again.');
        }
    }

    /**
     * Verify master passcode.
     */
    public function verifyPasscode(Request $request): RedirectResponse
    {
        $request->validate([
            'master_passcode' => 'required|string',
            'section' => 'required|string',
        ]);

        if ($this->settingsService->verifyMasterPasscode($request->master_passcode)) {
            session(['master_passcode_verified' => true, 'passcode_verified_at' => now()]);
            
            return redirect()
                ->route('settings.index', ['section' => $request->section])
                ->with('success', 'Master passcode verified successfully!');
        }

        return back()
            ->with('error', 'Invalid master passcode. Please try again.');
    }

    /**
     * Clear passcode verification.
     */
    public function clearPasscode(): RedirectResponse
    {
        session()->forget(['master_passcode_verified', 'passcode_verified_at']);
        
        return redirect()
            ->route('settings.index')
            ->with('success', 'Passcode verification cleared.');
    }
}