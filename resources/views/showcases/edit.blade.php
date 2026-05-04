@extends('layouts.app')

@section('title', 'Edit Showcase — Digital Twin Showcase')

@section('content')
<div class="max-w-3xl mx-auto fade-in">
    <div class="rounded-3xl bg-slate-900/70 border border-white/10 p-5 sm:p-6">
        <div class="mb-5">
            <p class="text-xs font-display font-600 uppercase tracking-widest text-brand-500 mb-2">Showcase</p>
            <h1 class="text-2xl sm:text-3xl font-display font-800 text-white">Edit Showcase</h1>
            <p class="mt-2 text-sm text-slate-400">{{ $showcase->serial_number }}</p>
        </div>

        @include('showcases._form', [
            'showcase' => $showcase,
            'users' => $users,
            'formAction' => route('showcases.update', $showcase),
            'formMethod' => 'PUT',
            'submitLabel' => 'Update Showcase',
            'isEdit' => true,
        ])
    </div>
</div>
@endsection