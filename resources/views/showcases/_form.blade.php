@php
    $isEdit = isset($isEdit) && $isEdit;
    $formAction = $formAction ?? '';
    $formMethod = $formMethod ?? 'POST';
    $submitLabel = $submitLabel ?? 'Simpan';
    $currentUser = auth()->user();
    $selectedImageUrl = old('image')
        ? null
        : ($showcase->image_url() ?? null);
@endphp

<form method="POST" action="{{ $formAction }}" enctype="multipart/form-data" id="formSubmit" class="space-y-5">
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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="rounded-2xl border border-white/10 bg-slate-950 p-4 sm:p-5">
            <div class="flex items-center justify-between gap-3 mb-4">
                <div>
                    <p class="text-xs uppercase tracking-wider text-slate-500 mb-1">Preview Gambar</p>
                    <p class="text-sm text-slate-300">{{ $isEdit ? 'Gambar aktif saat ini' : 'Pilih gambar untuk showcase' }}</p>
                </div>
            </div>

            @if($selectedImageUrl)
                <img
                    src="{{ $selectedImageUrl }}"
                    alt="Showcase image preview"
                    loading="lazy"
                    data-showcase-image-preview
                    class="w-full rounded-2xl border border-white/10 object-cover aspect-[16/10]"
                >
            @else
                <div class="flex h-48 items-center justify-center rounded-2xl border border-dashed border-white/10 text-sm text-slate-500">
                    No image available
                </div>
            @endif
        </div>

        <div class="rounded-2xl border border-white/10 bg-slate-950 p-4 sm:p-5 space-y-4">
            <div>
                <label class="block text-sm text-slate-300 mb-1.5">Upload Gambar Showcase</label>
                <input
                    type="file"
                    name="image"
                    accept="image/*"
                    data-showcase-image-input
                    class="w-full rounded-xl bg-slate-950 border border-white/10 px-4 py-3 text-sm text-white file:mr-4 file:rounded-lg file:border-0 file:bg-brand-600 file:px-4 file:py-2 file:text-sm file:font-display file:font-700 file:text-white hover:file:bg-brand-500 focus:border-brand-500/60 focus:outline-none"
                >
                @error('image')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="rounded-xl bg-slate-900/80 border border-white/5 p-4 text-sm text-slate-400 leading-relaxed">
                Upload gambar ringan untuk setiap showcase. Disarankan di bawah 200KB.
            </div>
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
        <button type="submit" id="submitBtn" class="inline-flex items-center justify-center rounded-xl bg-brand-600 hover:bg-brand-500 px-4 py-3 text-sm font-display font-700 text-white transition-colors">
            {{ $submitLabel }}
        </button>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formSubmit');
    const btn = document.getElementById('submitBtn');
    const input = document.querySelector('[data-showcase-image-input]');
    const preview = document.querySelector('[data-showcase-image-preview]');

    if (form && btn) {
        form.addEventListener('submit', function () {
            if (btn.disabled) {
                return;
            }

            btn.disabled = true;
            btn.innerText = 'Menyimpan...';
        });
    }

    if (!input || !preview) {
        return;
    }

    const updatePreview = (file) => {
        if (!file) {
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {
            preview.src = event.target.result;
            preview.alt = file.name;
        };

        reader.readAsDataURL(file);
    };

    input.addEventListener('change', function () {
        updatePreview(this.files && this.files[0] ? this.files[0] : null);
    });
});
</script>
@endpush