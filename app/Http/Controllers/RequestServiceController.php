<?php

namespace App\Http\Controllers;

use App\Models\RequestService;
use App\Models\Showcase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RequestServiceController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'serial_number' => ['required', 'string', 'exists:showcases,serial_number'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $showcase = Showcase::where('serial_number', $validated['serial_number'])->firstOrFail();

        $this->authorize('view', $showcase);

        RequestService::create([
            'showcase_id' => $showcase->id,
            'user_id' => $request->user()->id,
            'serial_number' => $showcase->serial_number,
            'description' => $validated['description'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('unit.show', $showcase->serial_number)
            ->with('success', 'Permintaan service untuk unit ' . $showcase->serial_number . ' berhasil disimpan.');
    }
}