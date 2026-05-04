@extends('layouts.app')

@section('title', 'Dashboard — Digital Twin Showcase')

@section('content')

<div class="mb-6 sm:mb-8 fade-in">
    <div class="rounded-3xl bg-slate-900/90 border border-white/10 p-5 sm:p-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <p class="text-xs font-display font-600 uppercase tracking-widest text-brand-500 mb-2">Portal B2B</p>
                <h1 class="text-2xl sm:text-4xl font-display font-800 text-white leading-tight">
                    @if($user->isAdmin())
                        Semua Unit
                    @elseif($user->isCoffee())
                        Unit Coffee Showcase
                    @else
                        Unit Chocolate Showcase
                    @endif
                </h1>
                <p class="mt-3 text-sm sm:text-base text-slate-400 font-body leading-relaxed">
                    @if($user->isAdmin())
                        Anda melihat seluruh {{ $showcases->count() }} unit dari semua klien. Gunakan daftar di bawah untuk masuk ke detail tiap unit.
                    @else
                        Anda memiliki <strong class="text-white">{{ $showcases->count() }}</strong> unit terdaftar. Buka salah satu kartu untuk melihat detail dan QR unit.
                    @endif
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:gap-4 lg:min-w-[280px]">
                <div class="rounded-2xl bg-slate-950 border border-white/8 p-4">
                    <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Total Unit</p>
                    <p class="text-2xl font-display font-800 text-white">{{ $showcases->count() }}</p>
                </div>
                <div class="rounded-2xl bg-slate-950 border border-white/8 p-4">
                    <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Role</p>
                    <p class="text-lg font-display font-700 text-white capitalize">{{ $user->role }}</p>
                </div>
                @if($user->isAdmin())
                <a href="{{ route('showcases.index') }}" class="col-span-2 rounded-2xl bg-brand-600 hover:bg-brand-500 text-white px-4 py-3 text-sm font-display font-700 transition-colors text-center">
                    Kelola Showcase
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Showcase Grid --}}
@if($showcases->isEmpty())
    <div class="text-center py-16 sm:py-20 fade-in-2 rounded-3xl bg-slate-900/60 border border-white/10">
        <div class="w-16 h-16 rounded-2xl bg-slate-800 flex items-center justify-center mx-auto mb-4 border border-white/10">
            <svg class="w-8 h-8 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
        <p class="text-slate-400 font-body">Belum ada unit terdaftar.</p>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5">
        @foreach($showcases as $index => $showcase)
        <a href="{{ route('unit.show', $showcase->serial_number) }}"
           class="group block rounded-3xl bg-slate-900/70 border border-white/10 p-5 sm:p-6 card-hover fade-in"
           style="animation-delay: {{ $index * 0.05 }}s">

            {{-- Card Header --}}
            <div class="flex items-start justify-between gap-3 mb-4">
                <div class="w-11 h-11 rounded-2xl flex items-center justify-center shrink-0
                    {{ $showcase->is_warranty_active ? 'bg-brand-900/60' : 'bg-red-900/60' }}">
                    <svg class="w-5 h-5 {{ $showcase->is_warranty_active ? 'text-brand-400' : 'text-red-400' }}"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                    </svg>
                </div>

                {{-- Warranty Badge --}}
                <span class="text-xs font-display font-600 px-2.5 py-1 rounded-full whitespace-nowrap
                    {{ $showcase->is_warranty_active ? 'badge-active text-brand-400' : 'badge-expired text-red-400' }}">
                    {{ $showcase->warranty_status }}
                </span>
            </div>

            {{-- Serial Number --}}
            <h2 class="text-lg sm:text-xl font-display font-700 text-white tracking-tight mb-1 group-hover:text-brand-400 transition-colors">
                {{ $showcase->serial_number }}
            </h2>

            {{-- Specs preview --}}
            <p class="text-sm text-slate-400 font-body mb-3 break-words">{{ $showcase->compressor_type }}</p>

            {{-- Warranty date --}}
            <div class="flex items-center justify-between gap-3 pt-3 border-t border-white/5">
                <span class="text-xs text-slate-500 font-body">Garansi s/d</span>
                <span class="text-xs font-body {{ $showcase->is_warranty_active ? 'text-brand-400' : 'text-red-400' }}">
                    {{ $showcase->warranty_expired_at->format('d M Y') }}
                </span>
            </div>

            {{-- Admin: show owner --}}
            @if($user->isAdmin())
            <div class="flex items-center gap-1.5 mt-2 pt-2 border-t border-white/5">
                <svg class="w-3 h-3 text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                </svg>
                <span class="text-xs text-slate-500 font-body">{{ $showcase->user->name }}</span>
                <span class="text-xs px-1.5 py-0.5 rounded font-display font-600 uppercase tracking-wide
                    {{ $showcase->user->role === 'coffee' ? 'text-amber-400 bg-amber-900/40' : 'text-orange-400 bg-orange-900/40' }}">
                    {{ $showcase->user->role }}
                </span>
            </div>
            @endif

            {{-- Arrow --}}
            <div class="flex items-center gap-1 mt-3 text-xs text-slate-500 group-hover:text-brand-400 transition-colors">
                <span class="font-body">Lihat detail</span>
                <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </a>
        @endforeach
    </div>
@endif

@endsection
