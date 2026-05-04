@extends('layouts.app')

@section('title', 'Request Service — Digital Twin Showcase')

@section('content')
<div class="mb-6 sm:mb-8 fade-in">
    <div class="rounded-3xl bg-slate-900/90 border border-white/10 p-5 sm:p-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl">
                <p class="text-xs font-display font-600 uppercase tracking-widest text-brand-500 mb-2">Service Requests</p>
                <h1 class="text-2xl sm:text-4xl font-display font-800 text-white leading-tight">Request Service</h1>
                <p class="mt-3 text-sm sm:text-base text-slate-400 font-body leading-relaxed">
                    @if($user->isAdmin())
                        Semua request service dari pengguna tampil di sini.
                    @else
                        Riwayat request service milik Anda tampil di sini.
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

@if($requestServices->isEmpty())
    <div class="rounded-3xl bg-slate-900/70 border border-white/10 p-8 text-center fade-in-2">
        <p class="text-slate-400 font-body">Belum ada request service.</p>
    </div>
@else
    <div class="grid grid-cols-1 gap-4">
        @foreach($requestServices as $requestService)
            <div class="rounded-3xl bg-slate-900/70 border border-white/10 p-5 sm:p-6 fade-in-2">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                    <div class="min-w-0 space-y-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-xs px-2.5 py-1 rounded-full font-display font-600 uppercase tracking-wider {{ $requestService->status === 'pending' ? 'bg-amber-900/40 text-amber-300 border border-amber-700/40' : 'bg-brand-900/40 text-brand-300 border border-brand-700/40' }}">
                                {{ $requestService->status }}
                            </span>
                            <span class="text-xs text-slate-500">{{ $requestService->created_at->format('d M Y H:i') }}</span>
                        </div>

                        <h2 class="text-lg font-display font-700 text-white break-words">
                            {{ $requestService->serial_number }}
                        </h2>

                        <p class="text-sm text-slate-400">
                            Showcase: <span class="text-slate-200">{{ $requestService->showcase->serial_number ?? '-' }}</span>
                        </p>

                        <p class="text-sm text-slate-300 break-words">
                            {{ $requestService->description ?: 'Tidak ada deskripsi.' }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-950 border border-white/8 p-4 text-sm text-slate-400 lg:w-64">
                        <p class="text-xs uppercase tracking-wider text-slate-500 mb-2">Dibuat oleh</p>
                        <p class="text-white font-body break-words">{{ $requestService->user->name ?? '-' }}</p>
                        <p class="mt-3 text-xs uppercase tracking-wider text-slate-500 mb-2">Showcase</p>
                        <a href="{{ route('unit.show', $requestService->serial_number) }}" class="text-brand-400 hover:text-brand-300 transition-colors break-words">
                            {{ $requestService->serial_number }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection