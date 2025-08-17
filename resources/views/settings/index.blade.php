@extends('layouts.app')

@section('title', 'Settings - Store Management')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Application Settings</h1>
                <p class="mt-2 text-gray-600">Configure your rental and e-commerce application settings</p>
            </div>
            @if(session('master_passcode_verified'))
                <div class="mt-4 sm:mt-0">
                    <form method="POST" action="{{ route('settings.clear-passcode') }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Clear Verification
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:w-1/4">
            <nav class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Settings Sections</h3>
                <ul class="space-y-2">
                    @foreach($sections as $key => $title)
                        <li>
                            <a href="{{ route('settings.index', ['section' => $key]) }}" 
                               class="flex items-center px-4 py-3 rounded-lg text-sm font-medium transition-colors {{ $activeSection === $key ? 'bg-blue-50 text-blue-700 border-l-4 border-blue-500' : 'text-gray-700 hover:bg-gray-50' }}">
                                @php
                                    $icons = [
                                        'admin' => 'shield-check',
                                        'contact' => 'phone',
                                        'payment' => 'credit-card',
                                        'product' => 'cog'
                                    ];
                                    $icon = $icons[$key] ?? 'cog';
                                @endphp
                                
                                @if($icon === 'shield-check')
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                @elseif($icon === 'phone')
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                @elseif($icon === 'credit-card')
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                @endif
                                {{ $title }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <!-- Quick Links -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h4 class="text-sm font-semibold text-gray-900 mb-3">Quick Links</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('stores.index') }}" 
                               class="flex items-center px-3 py-2 text-sm text-gray-600 hover:text-blue-600 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Stores Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="lg:w-3/4">
            @php
                $sectionConfig = $settingsConfig[$activeSection] ?? [];
                $requiresPasscode = in_array($activeSection, ['admin', 'payment']) && app('App\Services\SettingsService')->requiresPasscodeVerification();
            @endphp

            @if($requiresPasscode)
                <!-- Master Passcode Verification -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-4">
                            <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Master Passcode Required</h3>
                        <p class="text-gray-600 mb-6">This section requires master passcode verification to access sensitive settings.</p>
                        
                        <form method="POST" action="{{ route('settings.verify-passcode') }}" class="max-w-sm mx-auto">
                            @csrf
                            <input type="hidden" name="section" value="{{ $activeSection }}">
                            
                            <div class="mb-4">
                                <input type="password" 
                                       name="master_passcode" 
                                       placeholder="Enter master passcode"
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                            </div>
                            
                            <button type="submit" 
                                    class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                Verify Passcode
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Settings Form -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                    <!-- Section Header -->
                    <div class="px-8 py-6 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-100 rounded-lg">
                                @if($sectionConfig['icon'] === 'shield-check')
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                @elseif($sectionConfig['icon'] === 'phone')
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                @elseif($sectionConfig['icon'] === 'credit-card')
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $sectionConfig['title'] ?? 'Settings' }}</h2>
                                <p class="text-gray-600 mt-1">{{ $sectionConfig['description'] ?? 'Configure application settings' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('settings.update') }}" class="p-8 space-y-8">
                        @csrf
                        <input type="hidden" name="section" value="{{ $activeSection }}">

                        @if($activeSection === 'contact' && isset($settings['contact_note']))
                            <!-- Special Note for Contact Section -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-blue-800">
                                            <strong>Note:</strong> Store locations and addresses that appear on the Contact Us page are managed in the 
                                            <a href="{{ route('stores.index') }}" class="underline hover:text-blue-900">Stores Settings</a> section.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @foreach($sectionConfig['fields'] ?? [] as $fieldKey => $fieldConfig)
                            <div class="space-y-2">
                                <label for="{{ $fieldKey }}" class="block text-sm font-semibold text-gray-800">
                                    {{ $fieldConfig['label'] }}
                                    @if($fieldConfig['required'] ?? false)
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>

                                @if($fieldConfig['type'] === 'textarea')
                                    <textarea name="{{ $fieldKey }}" 
                                              id="{{ $fieldKey }}"
                                              rows="4"
                                              class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error($fieldKey) border-red-300 bg-red-50 @else border-gray-300 hover:border-gray-400 @enderror"
                                              placeholder="{{ $fieldConfig['description'] ?? '' }}"
                                              {{ ($fieldConfig['required'] ?? false) ? 'required' : '' }}>{{ old($fieldKey, $settings[$fieldKey] ?? '') }}</textarea>

                                @elseif($fieldConfig['type'] === 'select')
                                    <select name="{{ $fieldKey }}" 
                                            id="{{ $fieldKey }}"
                                            class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error($fieldKey) border-red-300 bg-red-50 @else border-gray-300 hover:border-gray-400 @enderror"
                                            {{ ($fieldConfig['required'] ?? false) ? 'required' : '' }}>
                                        @foreach($fieldConfig['options'] as $value => $label)
                                            <option value="{{ $value }}" {{ old($fieldKey, $settings[$fieldKey] ?? '') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>

                                @elseif($fieldConfig['type'] === 'radio')
                                    <div class="space-y-2">
                                        @foreach($fieldConfig['options'] as $index => $option)
                                            <label class="flex items-center space-x-3 cursor-pointer group">
                                                <input type="radio" 
                                                       name="{{ $fieldKey }}" 
                                                       value="{{ $index }}"
                                                       {{ old($fieldKey, $settings[$fieldKey] ?? '') == $index ? 'checked' : '' }}
                                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500"
                                                       {{ ($fieldConfig['required'] ?? false) ? 'required' : '' }}>
                                                <span class="text-gray-700 group-hover:text-gray-900 transition-colors">
                                                    {{ $option }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>

                                @elseif($fieldConfig['type'] === 'checkbox')
                                    <div class="flex items-center space-x-3">
                                        <input type="hidden" name="{{ $fieldKey }}" value="0">
                                        <input type="checkbox" 
                                               name="{{ $fieldKey }}" 
                                               id="{{ $fieldKey }}"
                                               value="1"
                                               {{ old($fieldKey, $settings[$fieldKey] ?? '') ? 'checked' : '' }}
                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="{{ $fieldKey }}" class="text-gray-700 cursor-pointer">
                                            Enable this option
                                        </label>
                                    </div>

                                @elseif($fieldKey === 'master_passcode')
                                    <div class="space-y-4">
                                        <input type="password" 
                                               name="{{ $fieldKey }}" 
                                               id="{{ $fieldKey }}"
                                               class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error($fieldKey) border-red-300 bg-red-50 @else border-gray-300 hover:border-gray-400 @enderror"
                                               placeholder="Enter new master passcode (leave blank to keep current)">
                                        
                                        <input type="password" 
                                               name="master_passcode_confirmation" 
                                               id="master_passcode_confirmation"
                                               class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent border-gray-300 hover:border-gray-400"
                                               placeholder="Confirm new master passcode">
                                    </div>

                                @else
                                    <div class="relative">
                                        <input type="{{ $fieldConfig['type'] }}" 
                                               name="{{ $fieldKey }}" 
                                               id="{{ $fieldKey }}"
                                               value="{{ old($fieldKey, $settings[$fieldKey] ?? '') }}"
                                               class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error($fieldKey) border-red-300 bg-red-50 @else border-gray-300 hover:border-gray-400 @enderror {{ isset($fieldConfig['suffix']) ? 'pr-12' : '' }}"
                                               placeholder="{{ $fieldConfig['description'] ?? '' }}"
                                               {{ isset($fieldConfig['step']) ? 'step=' . $fieldConfig['step'] : '' }}
                                               {{ isset($fieldConfig['min']) ? 'min=' . $fieldConfig['min'] : '' }}
                                               {{ isset($fieldConfig['max']) ? 'max=' . $fieldConfig['max'] : '' }}
                                               {{ ($fieldConfig['required'] ?? false) ? 'required' : '' }}>
                                        
                                        @if(isset($fieldConfig['suffix']))
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 text-sm">{{ $fieldConfig['suffix'] }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if(isset($fieldConfig['description']) && !in_array($fieldConfig['type'], ['textarea']))
                                    <p class="text-sm text-gray-600">{{ $fieldConfig['description'] }}</p>
                                @endif

                                @error($fieldKey)
                                    <p class="text-sm text-red-600 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        @endforeach

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                            <button type="submit" 
                                    class="flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Update Settings
                            </button>
                            
                            @if($activeSection === 'admin')
                                <button type="button" 
                                        onclick="document.getElementById('update-edit-button').style.display = 'block'"
                                        class="flex items-center justify-center gap-2 px-6 py-3 bg-yellow-600 text-white rounded-lg font-semibold hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Update / Edit
                                </button>
                            @endif
                        </div>

                        @if($activeSection === 'admin')
                            <div id="update-edit-button" style="display: none;" class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <p class="text-sm text-yellow-800">
                                    <strong>Note:</strong> This button requires the Master Passcode to access and edit the encrypted Master Passcode field.
                                </p>
                            </div>
                        @endif
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Phone number formatting for contact section
@if($activeSection === 'contact')
document.getElementById('contact_phone')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 6) {
        value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
    } else if (value.length >= 3) {
        value = value.replace(/(\d{3})(\d{0,3})/, '($1) $2');
    }
    e.target.value = value;
});
@endif

// Master passcode confirmation validation
@if($activeSection === 'admin')
const passcodeField = document.getElementById('master_passcode');
const confirmField = document.getElementById('master_passcode_confirmation');

function validatePasscodeMatch() {
    if (passcodeField.value && confirmField.value) {
        if (passcodeField.value !== confirmField.value) {
            confirmField.setCustomValidity('Passcodes do not match');
        } else {
            confirmField.setCustomValidity('');
        }
    }
}

passcodeField?.addEventListener('input', validatePasscodeMatch);
confirmField?.addEventListener('input', validatePasscodeMatch);
@endif
</script>
@endsection