@php
    $isEdit = isset($isEdit) && $isEdit;
    $formAction = $formAction ?? '';
    $formMethod = $formMethod ?? 'POST';
    $submitLabel = $submitLabel ?? 'Simpan';
    $currentUser = auth()->user();
@endphp

<form method="POST" action="{{ $formAction }}" class="space-y-5">
    @csrf
    @if($formMethod !== 'POST')
        @method($formMethod)
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm text-slate-300 mb-1.5">Warranty Expired At</label>
            <input
                type="date"
                name="warranty_expired_at"
                value="{{ old('warranty_expired_at', optional($showcase->warranty_expired_at)->format('Y-m-d')) }}"
                class="w-full rounded-xl bg-slate-950 border border-white/10 px-4 py-3 text-sm text-white focus:border-brand-500/60 focus:outline-none"
                required
            >
            @error('warranty_expired_at')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm text-slate-300 mb-1.5">Compressor Type</label>
            <input
                type="text"
                name="compressor_type"
                value="{{ old('compressor_type', $showcase->compressor_type) }}"
                class="w-full rounded-xl bg-slate-950 border border-white/10 px-4 py-3 text-sm text-white focus:border-brand-500/60 focus:outline-none"
                required
            >
            @error('compressor_type')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm text-slate-300 mb-1.5">Glass Specification</label>
            <input
                type="text"
                name="glass_spec"
                value="{{ old('glass_spec', $showcase->glass_spec) }}"
                class="w-full rounded-xl bg-slate-950 border border-white/10 px-4 py-3 text-sm text-white focus:border-brand-500/60 focus:outline-none"
                required
            >
            @error('glass_spec')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    @if($isEdit)
        <div class="rounded-2xl border border-white/10 bg-slate-950 px-4 py-3">
            <p class="text-xs uppercase tracking-wider text-slate-500 mb-1">Serial Number</p>
            <p class="text-sm font-display font-700 text-white">{{ $showcase->serial_number }}</p>
        </div>
    @endif

    @if($currentUser->isAdmin())
        <div>
            <label class="block text-sm text-slate-300 mb-1.5">Owner</label>
            <select
                name="user_id"
                class="w-full rounded-xl bg-slate-950 border border-white/10 px-4 py-3 text-sm text-white focus:border-brand-500/60 focus:outline-none"
            >
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id', $showcase->user_id ?: $currentUser->id) == $user->id)>
                        {{ $user->name }} ({{ $user->role }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>
    @endif

    <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
        <a href="{{ route('showcases.index') }}" class="inline-flex items-center justify-center rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 px-4 py-3 text-sm text-white transition-colors">
            Batal
        </a>
        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-brand-600 hover:bg-brand-500 px-4 py-3 text-sm font-display font-700 text-white transition-colors">
            {{ $submitLabel }}
        </button>
    </div>
</form>