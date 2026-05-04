<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Digital Twin Showcase')</title>

    {{-- Tailwind CSS via CDN (replace with Vite asset() in production) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Google Fonts: Syne + DM Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Syne', 'sans-serif'],
                        body: ['DM Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50:  '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            900: '#14532d',
                        },
                        slate: {
                            850: '#1a2234',
                            950: '#0b1120',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'DM Sans', sans-serif; }
        h1,h2,h3,h4 { font-family: 'Syne', sans-serif; }
        .nav-glass {
            background: rgba(11, 17, 32, 0.96);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 30px rgba(0,0,0,0.22);
        }
        .badge-active {
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.28);
        }
        .badge-expired {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.28);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.4s ease both; }
        .fade-in-2 { animation: fadeIn 0.4s 0.1s ease both; }
        .fade-in-3 { animation: fadeIn 0.4s 0.2s ease both; }
    </style>

    @stack('styles')
</head>
<body class="bg-slate-950 min-h-full text-slate-100">

    {{-- Navigation --}}
    <nav class="nav-glass fixed top-0 left-0 right-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-3 py-3 sm:h-16 sm:flex-row sm:items-center sm:justify-between sm:py-0">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group self-start">
                    <div class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center group-hover:bg-brand-500 transition-colors">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                        </svg>
                    </div>
                    <span class="font-display font-700 text-white tracking-tight">
                        Digital<span class="text-brand-500">Twin</span>
                    </span>
                </a>

                {{-- User menu --}}
                @auth
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-3 sm:self-auto self-stretch">
                    <div class="flex items-center justify-between gap-2 sm:justify-start">
                        <span class="text-xs text-slate-400 font-body">{{ Auth::user()->name }}</span>
                        <span class="text-xs px-2 py-0.5 rounded-full font-display font-600 uppercase tracking-wider
                            {{ Auth::user()->role === 'admin' ? 'bg-violet-900/60 text-violet-300 border border-violet-700/50' : '' }}
                            {{ Auth::user()->role === 'coffee' ? 'bg-amber-900/60 text-amber-300 border border-amber-700/50' : '' }}
                            {{ Auth::user()->role === 'chocolate' ? 'bg-orange-900/60 text-orange-300 border border-orange-700/50' : '' }}
                        ">
                            {{ Auth::user()->role }}
                        </span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto text-xs text-slate-300 hover:text-white transition-colors px-3 py-2 rounded-lg bg-white/5 hover:bg-white/10 font-body border border-white/10">
                            Logout
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="pt-20 sm:pt-16 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="mb-6 flex items-start gap-3 p-4 rounded-xl bg-brand-950/60 border border-brand-700/40 fade-in">
                <svg class="w-5 h-5 text-brand-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-brand-300">{{ session('success') }}</p>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 flex items-start gap-3 p-4 rounded-xl bg-red-950/60 border border-red-700/40 fade-in">
                <svg class="w-5 h-5 text-red-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm text-red-300">{{ session('error') }}</p>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="border-t border-white/5 py-6 mt-auto bg-slate-950/80">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs text-slate-500 font-body">
                &copy; {{ date('Y') }} Digital Twin Showcase — B2B Portal
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
