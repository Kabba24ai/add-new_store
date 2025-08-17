<?php

use App\Http\Controllers\StoreController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect root to stores index
Route::get('/', function () {
    return redirect()->route('stores.index');
});

// Store management routes
Route::resource('stores', StoreController::class);

// Additional store routes
Route::patch('stores/{store}/toggle-status', [StoreController::class, 'toggleStatus'])
    ->name('stores.toggle-status');

// Settings management routes
Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
Route::post('settings/verify-passcode', [SettingsController::class, 'verifyPasscode'])->name('settings.verify-passcode');
Route::post('settings/clear-passcode', [SettingsController::class, 'clearPasscode'])->name('settings.clear-passcode');