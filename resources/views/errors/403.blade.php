@extends('layouts.app')

@section('title', '403 — Akses Ditolak')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-8 sm:py-12">
    <div class="text-center max-w-md fade-in px-4 sm:px-0">
        {{-- Error code --}}
        <div class="text-7xl sm:text-8xl font-display font-800 text-white/10 mb-4 leading-none select-none">403</div>

        <div class="w-16 h-16 rounded-2xl bg-red-950/60 border border-red-700/40 flex items-center justify-center mx-auto mb-6 -mt-10">
            <svg class="w-8 h-8 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>

        <h1 class="text-2xl sm:text-3xl font-display font-700 text-white mb-2">Akses Ditolak</h1>
        <p class="text-slate-400 font-body text-sm leading-relaxed mb-8">
            Anda tidak memiliki izin untuk mengakses unit ini.<br>
            Data unit terisolasi — hanya pemilik yang dapat mengakses.
        </p>

        <a href="{{ route('dashboard') }}"
           class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-brand-600 hover:bg-brand-500 text-white text-sm font-display font-700 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
