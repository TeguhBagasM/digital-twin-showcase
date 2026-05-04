<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Digital Twin Showcase</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Syne', 'sans-serif'],
                        body: ['DM Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h1,h2,h3 { font-family: 'Syne', sans-serif; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.5s ease both; }
    </style>
</head>
<body class="bg-slate-950 min-h-full flex items-center justify-center p-4 sm:p-6">

    <div class="w-full max-w-md fade-in">

        {{-- Logo --}}
        <div class="text-center mb-6 sm:mb-8">
            <div class="w-14 h-14 rounded-2xl bg-brand-600 flex items-center justify-center mx-auto mb-4 border border-white/10">
                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                </svg>
            </div>
            <h1 class="text-2xl font-display font-800 text-white tracking-tight">
                Digital<span class="text-green-500">Twin</span>
            </h1>
            <p class="text-slate-400 text-sm font-body mt-1">B2B Showcase Portal</p>
        </div>

        {{-- Card --}}
        <div class="rounded-3xl bg-slate-900 border border-white/10 p-5 sm:p-8 shadow-2xl shadow-black/20">

            <h2 class="text-xl font-display font-700 text-white mb-5 sm:mb-6">Masuk ke Akun</h2>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="mb-4 text-sm text-green-300 font-body bg-green-950/60 border border-green-800/40 rounded-xl px-3 py-2">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="text-xs text-slate-400 font-body block mb-1.5">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="nama@mail.com"
                           class="w-full rounded-xl bg-slate-950 border text-white text-sm font-body px-4 py-3
                               focus:outline-none transition-colors placeholder-slate-600
                               {{ $errors->has('email') ? 'border-red-500/50' : 'border-white/10 focus:border-brand-500/50' }}"
                    >
                    @error('email')
                        <p class="text-xs text-red-400 mt-1 font-body">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="text-xs text-slate-400 font-body block mb-1.5">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                           class="w-full rounded-xl bg-slate-950 border border-white/10 text-white text-sm font-body px-4 py-3
                               focus:outline-none focus:border-brand-500/50 transition-colors placeholder-slate-600
                               {{ $errors->has('password') ? 'border-red-500/50' : 'border-white/10 focus:border-green-500/50' }}"
                    >
                    @error('password')
                        <p class="text-xs text-red-400 mt-1 font-body">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2">
                    <input
                        id="remember_me"
                        name="remember"
                        type="checkbox"
                        class="rounded border-slate-600 bg-slate-950 text-brand-600 focus:ring-brand-500/30"
                    >
                    <label for="remember_me" class="text-xs text-slate-400 font-body">Ingat saya</label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full py-3 rounded-xl font-display font-700 text-sm text-white
                           bg-brand-600 hover:bg-brand-500 active:scale-95
                           transition-all duration-200">
                    Masuk
                </button>
            </form>

            {{-- Demo accounts hint --}}
            <div class="mt-5 pt-5 border-t border-white/8">
                <p class="text-xs text-slate-500 font-body text-center mb-3">Demo Accounts</p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs font-body">
                    <div class="rounded-lg bg-slate-950 p-3 text-center border border-white/8">
                        <p class="text-violet-300 font-500 mb-0.5">Admin</p>
                        <p class="text-slate-400">admin@mail.com</p>
                    </div>
                    <div class="rounded-lg bg-slate-950 p-3 text-center border border-white/8">
                        <p class="text-amber-300 font-500 mb-0.5">Coffee</p>
                        <p class="text-slate-400">coffee@mail.com</p>
                    </div>
                    <div class="rounded-lg bg-slate-950 p-3 text-center border border-white/8">
                        <p class="text-orange-300 font-500 mb-0.5">Choco</p>
                        <p class="text-slate-400">choco@mail.com</p>
                    </div>
                </div>
                <p class="text-center text-xs text-slate-500 font-body mt-2">password: <span class="text-slate-300">password</span></p>
            </div>

        </div>

    </div>

</body>
</html>
