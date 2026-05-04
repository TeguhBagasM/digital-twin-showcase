@extends('layouts.app')

@section('title', 'Tambah Showcase — Digital Twin Showcase')

@section('content')
<div class="max-w-3xl mx-auto fade-in">
    <div class="rounded-3xl bg-slate-900/70 border border-white/10 p-5 sm:p-6">
        <div class="mb-5">
            <p class="text-xs font-display font-600 uppercase tracking-widest text-brand-500 mb-2">Showcase</p>
            <h1 class="text-2xl sm:text-3xl font-display font-800 text-white">Tambah Showcase</h1>
        </div>

        @include('showcases._form', [
            'showcase' => $showcase,
            'users' => $users,
            'formAction' => route('showcases.store'),
            'formMethod' => 'POST',
            'submitLabel' => 'Simpan Showcase',
            'isEdit' => false,
        ])
    </div>
</div>
@endsection