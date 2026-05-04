<?php

use App\Http\Controllers\ShowcaseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ─── Public / Auth Routes (Breeze generates these) ────────────────────────────
require __DIR__.'/auth.php';

// ─── Redirect root to dashboard ───────────────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ─── Protected Routes (must be authenticated) ─────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard: scoped by role
    Route::get('/dashboard', [ShowcaseController::class, 'index'])
        ->name('dashboard');

    // Unit Passport (SEO-friendly URL)
    Route::get('/unit/{serial_number}', [ShowcaseController::class, 'show'])
        ->name('unit.show');

    // Request Service form submission
    Route::post('/unit/request-service', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'serial_number' => 'required|string|exists:showcases,serial_number',
            'description'   => 'nullable|string|max:500',
        ]);

        // TODO: Store to service_requests table or send notification
        // For now, redirect back with success message
        return redirect()
            ->route('unit.show', $request->serial_number)
            ->with('success', 'Permintaan service untuk unit ' . $request->serial_number . ' telah dikirim.');
    })->name('unit.request-service');

});

// ─── Admin-only routes (example with RoleMiddleware) ──────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Future admin management routes go here
});
