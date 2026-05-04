<?php

use App\Http\Controllers\ShowcaseController;
use App\Http\Controllers\RequestServiceController;
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

    // Showcase CRUD management
    Route::get('/showcases', [ShowcaseController::class, 'index'])
        ->name('showcases.index');
    Route::get('/showcases/create', [ShowcaseController::class, 'create'])
        ->name('showcases.create');
    Route::post('/showcases', [ShowcaseController::class, 'store'])
        ->name('showcases.store');
    Route::get('/showcases/{showcase}/edit', [ShowcaseController::class, 'edit'])
        ->name('showcases.edit');
    Route::put('/showcases/{showcase}', [ShowcaseController::class, 'update'])
        ->name('showcases.update');
    Route::delete('/showcases/{showcase}', [ShowcaseController::class, 'destroy'])
        ->name('showcases.destroy');

    // Unit Passport (SEO-friendly URL)
    Route::get('/unit/{serial_number}', [ShowcaseController::class, 'show'])
        ->name('unit.show');

    // Request Service form submission
    Route::post('/unit/request-service', [RequestServiceController::class, 'store'])
        ->name('unit.request-service');

});

// ─── Admin-only routes (example with RoleMiddleware) ──────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Future admin management routes go here
});
