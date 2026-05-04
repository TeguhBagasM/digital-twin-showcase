@extends('layouts.app')

@section('title', 'Unit ' . $showcase->serial_number . ' — Digital Twin Showcase')

@section('content')

{{-- Breadcrumb --}}
<nav class="flex flex-wrap items-center gap-2 mb-5 sm:mb-6 text-xs text-slate-500 font-body fade-in">
    <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Dashboard</a>
    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-slate-300">{{ $showcase->serial_number }}</span>
</nav>

{{-- Unit Passport Card --}}
<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="mb-5 sm:mb-6 fade-in">
        <p class="text-xs font-display font-600 uppercase tracking-widest text-brand-500 mb-1">Unit Passport</p>
        <h1 class="text-2xl sm:text-4xl font-display font-800 text-white leading-tight break-words">{{ $showcase->serial_number }}</h1>
    </div>

    {{-- Showcase Image --}}
    <div class="mb-4 sm:mb-5 fade-in-2 max-w-md mx-auto">
        @if($showcase->image)
            <img
                src="{{ $showcase->image_url() }}"
                alt="Showcase {{ $showcase->serial_number }}"
                loading="lazy"
                class="w-full max-w-md h-auto object-contain rounded-lg border border-white/10 shadow-md shadow-black/10"
            >
        @else
            <div class="rounded-2xl border border-white/10 bg-slate-900/70 px-4 py-8 text-center text-sm text-slate-500">
                No image available
            </div>
        @endif
    </div>

    {{-- Main Info Card --}}
    <div class="rounded-3xl bg-slate-900/70 border border-white/10 overflow-hidden fade-in-2 mb-4 sm:mb-5 shadow-lg shadow-black/10">

        {{-- Status Banner --}}
        <div class="px-4 sm:px-6 py-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-b
            {{ $showcase->is_warranty_active
                ? 'bg-brand-950/50 border-brand-800/40'
                : 'bg-red-950/50 border-red-800/40' }}">

            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-3 h-3 rounded-full {{ $showcase->is_warranty_active ? 'bg-brand-500' : 'bg-red-500' }}"></div>
                    @if($showcase->is_warranty_active)
                    <div class="absolute inset-0 rounded-full bg-brand-500 animate-ping opacity-40"></div>
                    @endif
                </div>
                <div>
                    <p class="text-xs text-slate-400 font-body">Status Garansi</p>
                    <p class="font-display font-700 {{ $showcase->is_warranty_active ? 'text-brand-400' : 'text-red-400' }}">
                        {{ $showcase->warranty_status }}
                    </p>
                </div>
            </div>

            <div class="text-left sm:text-right">
                <p class="text-xs text-slate-400 font-body">Berlaku hingga</p>
                <p class="text-sm font-body font-500 {{ $showcase->is_warranty_active ? 'text-brand-300' : 'text-red-300' }}">
                    {{ $showcase->warranty_expired_at->format('d M Y') }}
                </p>
            </div>
        </div>

        {{-- Specs Grid --}}
        <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">

            {{-- Serial Number --}}
            <div class="col-span-full">
                <p class="text-xs text-slate-500 font-body uppercase tracking-wider mb-1">Serial Number</p>
                <p class="text-lg sm:text-xl font-display font-700 text-white tracking-tight break-words">{{ $showcase->serial_number }}</p>
            </div>

            {{-- Compressor Type --}}
            <div>
                <p class="text-xs text-slate-500 font-body uppercase tracking-wider mb-1">Compressor Type</p>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p class="text-white font-body font-500 break-words">{{ $showcase->compressor_type }}</p>
                </div>
            </div>

            {{-- Glass Spec --}}
            <div>
                <p class="text-xs text-slate-500 font-body uppercase tracking-wider mb-1">Glass Specification</p>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-brand-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7"/>
                    </svg>
                    <p class="text-white font-body font-500 break-words">{{ $showcase->glass_spec }}</p>
                </div>
            </div>

            {{-- Registered Date --}}
            <div>
                <p class="text-xs text-slate-500 font-body uppercase tracking-wider mb-1">Registered</p>
                <p class="text-white font-body">{{ $showcase->created_at->format('d M Y') }}</p>
            </div>

            {{-- Owner (for admin) --}}
            @if(Auth::user()->isAdmin())
            <div>
                <p class="text-xs text-slate-500 font-body uppercase tracking-wider mb-1">Client</p>
                <div class="flex flex-wrap items-center gap-2">
                    <p class="text-white font-body break-words">{{ $showcase->user->name }}</p>
                    <span class="text-xs px-2 py-0.5 rounded font-display font-600 uppercase
                        {{ $showcase->user->role === 'coffee' ? 'text-amber-400 bg-amber-900/40' : 'text-orange-400 bg-orange-900/40' }}">
                        {{ $showcase->user->role }}
                    </span>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- QR Code + Request Service: side by side on desktop --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 fade-in-3">

        {{-- QR Code Card --}}
        <div class="rounded-3xl bg-slate-900/70 border border-white/10 p-5 sm:p-6 flex flex-col items-center text-center order-2 lg:order-1">
            <p class="text-xs font-display font-600 uppercase tracking-widest text-slate-400 mb-4">QR Code Unit</p>

            {{-- QR Code using simplesoftwareio/simple-qrcode --}}
            <div class="rounded-2xl bg-white p-3 inline-block mb-3">
                {!! QrCode::format('svg')
                    ->size(150)
                    ->color(11, 17, 32)
                    ->generate(route('unit.show', $showcase->serial_number)) !!}
            </div>

            <p class="text-xs text-slate-400 font-body mt-2">
                Scan untuk akses<br>
                <span class="text-slate-300 font-500">{{ $showcase->serial_number }}</span>
            </p>
        </div>

        {{-- Request Service Form --}}
        <div class="rounded-3xl bg-slate-900/70 border border-white/10 p-5 sm:p-6 flex flex-col order-1 lg:order-2">
            <p class="text-xs font-display font-600 uppercase tracking-widest text-slate-400 mb-4">Request Service</p>

            <form method="POST" action="{{ route('unit.request-service') }}" class="flex flex-col gap-4 flex-1">
                @csrf

                {{-- Hidden serial number --}}
                <input type="hidden" name="serial_number" value="{{ $showcase->serial_number }}">

                {{-- Optional description --}}
                <div>
                    <label class="text-xs text-slate-400 font-body block mb-1.5">Deskripsi masalah (opsional)</label>
                    <textarea
                        name="description"
                        rows="5"
                        placeholder="Jelaskan masalah atau kebutuhan service..."
                        class="w-full rounded-xl bg-slate-950 border border-white/10 text-white text-sm font-body px-4 py-3 resize-none focus:outline-none focus:border-brand-500/50 transition-colors placeholder-slate-600"
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Info row --}}
                <div class="flex items-center gap-2 text-xs text-slate-500 font-body">
                    <svg class="w-3.5 h-3.5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Unit: <span class="text-slate-300 font-500">{{ $showcase->serial_number }}</span>
                </div>

                {{-- Submit button --}}
                <button type="submit"
                    class="mt-auto w-full py-3 px-5 rounded-xl font-display font-700 text-sm text-white
                           bg-brand-600 hover:bg-brand-500 active:scale-95
                           transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Request Service
                </button>
            </form>
        </div>

    </div>

    {{-- Back link --}}
    <div class="mt-6 text-center fade-in-3">
        <a href="{{ route('dashboard') }}" class="text-sm text-slate-500 hover:text-white transition-colors font-body inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

</div>

@endsection
