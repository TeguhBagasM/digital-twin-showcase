<?php

namespace App\Http\Controllers;

use App\Models\Showcase;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ShowcaseController extends Controller
{
    /**
     * Dashboard: show showcases based on user role.
     * Admin sees all; clients see only their own.
     */
    public function index(Request $request): View
    {
        /** @var User $user */
        $user = Auth::user();

        $showcases = $user->isAdmin()
            ? Showcase::with('user')->latest()->get()
            : Showcase::with('user')->where('user_id', $user->id)->latest()->get();

        if ($request->routeIs('showcases.index')) {
            $this->authorize('viewAny', Showcase::class);

            return view('showcases.index', compact('showcases', 'user'));
        }

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
        $this->authorize('view', $showcase);

        return view('unit.show', compact('showcase'));
    }

    public function create(): View
    {
        $this->authorize('create', Showcase::class);

        return view('showcases.create', [
            'showcase' => new Showcase(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Showcase::class);

        $validated = $request->validate([
            'warranty_expired_at' => ['required', 'date'],
            'compressor_type' => ['required', 'string', 'max:255'],
            'glass_spec' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:webp', 'max:2048'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $user = $request->user();

        $showcase = DB::transaction(function () use ($validated, $user) {
            $serialNumber = Showcase::generateSerialNumber();
            $imageFile = request()->file('image');
            $imagePath = 'showcases/' . $serialNumber . '.webp';
            $imageFile->move(public_path('images/showcases'), $serialNumber . '.webp');

            return Showcase::create([
                'serial_number' => $serialNumber,
                'user_id' => $user->isAdmin() && !empty($validated['user_id'])
                    ? $validated['user_id']
                    : $user->id,
                'warranty_expired_at' => $validated['warranty_expired_at'],
                'compressor_type' => $validated['compressor_type'],
                'glass_spec' => $validated['glass_spec'],
                'image' => $imagePath,
            ]);
        });

        return redirect()
            ->route('showcases.index')
            ->with('success', 'Showcase ' . $showcase->serial_number . ' berhasil ditambahkan.');
    }

    public function edit(Showcase $showcase): View
    {
        $this->authorize('update', $showcase);

        return view('showcases.edit', [
            'showcase' => $showcase->load('user'),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Showcase $showcase): RedirectResponse
    {
        $this->authorize('update', $showcase);

        $validated = $request->validate([
            'warranty_expired_at' => ['required', 'date'],
            'compressor_type' => ['required', 'string', 'max:255'],
            'glass_spec' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:webp', 'max:2048'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $user = $request->user();
        $imagePath = $showcase->image;

        if ($request->hasFile('image')) {
            if ($showcase->image && str_starts_with($showcase->image, 'showcases/')) {
                $existingImage = public_path('images/' . $showcase->image);

                if (file_exists($existingImage)) {
                    unlink($existingImage);
                }
            }

            $request->file('image')->move(public_path('images/showcases'), $showcase->serial_number . '.webp');
            $imagePath = 'showcases/' . $showcase->serial_number . '.webp';
        }

        $showcase->update([
            'user_id' => $user->isAdmin() && !empty($validated['user_id'])
                ? $validated['user_id']
                : $showcase->user_id,
            'warranty_expired_at' => $validated['warranty_expired_at'],
            'compressor_type' => $validated['compressor_type'],
            'glass_spec' => $validated['glass_spec'],
            'image' => $imagePath,
        ]);

        return redirect()
            ->route('showcases.index')
            ->with('success', 'Showcase ' . $showcase->serial_number . ' berhasil diperbarui.');
    }

    public function destroy(Showcase $showcase): RedirectResponse
    {
        $this->authorize('delete', $showcase);

        $serialNumber = $showcase->serial_number;
        $showcase->delete();

        return redirect()
            ->route('showcases.index')
            ->with('success', 'Showcase ' . $serialNumber . ' berhasil dihapus.');
    }
}
