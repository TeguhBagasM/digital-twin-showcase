@extends('layouts.app')

@section('title', 'Kelola Showcase — Digital Twin Showcase')

@section('content')
<div class="mb-6 sm:mb-8 fade-in">
    <div class="rounded-3xl bg-slate-900/90 border border-white/10 p-5 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-display font-600 uppercase tracking-widest text-brand-500 mb-2">Showcase Management</p>
                <h1 class="text-2xl sm:text-4xl font-display font-800 text-white leading-tight">Kelola Showcase</h1>
                <p class="mt-3 text-sm text-slate-400 font-body">Tambah, ubah, atau hapus data showcase dari satu tempat.</p>
            </div>

            <a href="{{ route('showcases.create') }}" class="inline-flex items-center justify-center rounded-xl bg-brand-600 hover:bg-brand-500 text-white px-4 py-3 text-sm font-display font-700 transition-colors">
                Tambah Showcase
            </a>
        </div>
    </div>
</div>

@if($showcases->isEmpty())
    <div class="rounded-3xl bg-slate-900/70 border border-white/10 p-8 text-center fade-in-2">
        <p class="text-slate-400 font-body">Belum ada showcase tersedia.</p>
    </div>
@else
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-5">
        @foreach($showcases as $showcase)
            <div class="rounded-3xl bg-slate-900/70 border border-white/10 p-5 sm:p-6 fade-in-2">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div class="min-w-0">
                        <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Serial Number</p>
                        <h2 class="text-xl font-display font-700 text-white break-words">{{ $showcase->serial_number }}</h2>
                        <p class="mt-2 text-sm text-slate-400 break-words">{{ $showcase->compressor_type }}</p>
                        <p class="mt-1 text-sm text-slate-400 break-words">{{ $showcase->glass_spec }}</p>
                    </div>

                    <div class="shrink-0 text-left sm:text-right">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-display font-600 {{ $showcase->is_warranty_active ? 'badge-active text-brand-400' : 'badge-expired text-red-400' }}">
                            {{ $showcase->warranty_status }}
                        </span>
                        <p class="mt-2 text-xs text-slate-500">Berlaku hingga</p>
                        <p class="text-sm text-slate-200">{{ $showcase->warranty_expired_at->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-t border-white/5 pt-4">
                    <div class="text-sm text-slate-400">
                        @if($showcase->relationLoaded('user') || $showcase->user)
                            <span class="text-slate-500">Owner:</span> {{ $showcase->user->name }}
                        @endif
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('showcases.edit', $showcase) }}" class="inline-flex items-center justify-center rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 px-4 py-2.5 text-sm text-white transition-colors">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('showcases.destroy', $showcase) }}" onsubmit="return confirm('Hapus showcase ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-red-600/90 hover:bg-red-500 px-4 py-2.5 text-sm text-white transition-colors">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection