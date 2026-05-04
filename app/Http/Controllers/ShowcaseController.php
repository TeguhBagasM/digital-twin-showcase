<?php

namespace App\Http\Controllers;

use App\Models\Showcase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ShowcaseController extends Controller
{
    /**
     * Dashboard: show showcases based on user role.
     * Admin sees all; clients see only their own.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $showcases = $user->isAdmin()
            ? Showcase::with('user')->latest()->get()
            : Showcase::where('user_id', $user->id)->latest()->get();

        return view('dashboard.index', compact('showcases', 'user'));
    }

    /**
     * Unit Passport: detail page for a single showcase.
     * Uses Policy to enforce data isolation — 403 if unauthorized.
     */
    public function show(string $serialNumber)
    {
        $showcase = Showcase::where('serial_number', $serialNumber)->firstOrFail();

        // Enforce policy: user can only view their own showcase (admin bypasses)
        Gate::authorize('view', $showcase);

        return view('unit.show', compact('showcase'));
    }
}
