<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Cabang') — Katiga Veritas</title>
    <!-- Use Tailwind CDN so that the view looks exceptionally curated and premium -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 flex text-slate-800">

    <!-- SIDEBAR -->
    <aside class="w-72 min-h-screen bg-gradient-to-b from-slate-900 to-indigo-950 flex flex-col fixed top-0 left-0 z-40 shadow-2xl text-slate-100">
        
        <!-- Logo -->
        <div class="p-6 border-b border-slate-800/80 flex items-center gap-3">
            <div class="w-11 h-11 bg-gradient-to-tr from-cyan-500 to-teal-400 rounded-xl flex items-center justify-center text-slate-900 font-extrabold text-lg shadow-lg shadow-cyan-500/30">
                K
            </div>
            <div>
                <div class="font-extrabold text-base tracking-wide bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent">Katiga Veritas</div>
                <div class="text-xs text-cyan-400/90 font-medium tracking-wider uppercase">Cabang {{ strtoupper(Auth::user()->adminCabang()) }}</div>
            </div>
        </div>

        <!-- User Profile Card -->
        <div class="px-5 py-4 border-b border-slate-800/80 mx-2 my-2 rounded-xl bg-slate-800/40 backdrop-blur-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-slate-950 text-sm font-black shadow-md shadow-orange-500/20">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-white text-sm font-bold truncate">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-orange-400 font-medium">Admin Cabang</div>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-3 space-y-1.5 overflow-y-auto">
            <div class="text-xs font-semibold text-slate-500 uppercase px-2 py-1 tracking-wider">Utama</div>
            
            <a href="{{ route('branch-admin.dashboard') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('branch-admin.dashboard') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20 active' : 'text-slate-400' }}">
                <span class="text-base">📊</span> Dashboard
            </a>

            <div class="text-xs font-semibold text-slate-500 uppercase px-2 pt-4 py-1 tracking-wider">Kelola Cabang</div>

            <a href="{{ route('branch-admin.layanan.index') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('branch-admin.layanan.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20 active' : 'text-slate-400' }}">
                <span class="text-base">🛠️</span> Layanan Cabang
            </a>

            <a href="{{ route('branch-admin.klien.index') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('branch-admin.klien.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20 active' : 'text-slate-400' }}">
                <span class="text-base">🏢</span> Klien / Mitra
            </a>

            <a href="{{ route('branch-admin.peserta.index') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('branch-admin.peserta.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20 active' : 'text-slate-400' }}">
                <span class="text-base">📋</span> Peserta & Riwayat
            </a>

            <a href="{{ route('branch-admin.jadwal.index') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('branch-admin.jadwal.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20 active' : 'text-slate-400' }}">
                <span class="text-base">📅</span> Jadwal Cabang
            </a>

            <a href="{{ route('branch-admin.sertifikat.index') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('branch-admin.sertifikat.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20 active' : 'text-slate-400' }}">
                <span class="text-base">🏆</span> Sertifikat
            </a>

            <div class="text-xs font-semibold text-slate-500 uppercase px-2 pt-4 py-1 tracking-wider">Laporan</div>

            <a href="{{ route('branch-admin.laporan.index') }}" 
               class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('branch-admin.laporan.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20 active' : 'text-slate-400' }}">
                <span class="text-base">📈</span> Laporan Statistik
            </a>
        </nav>

        <!-- Logout Section -->
        <div class="p-4 border-t border-slate-800/80">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center justify-center gap-2.5 px-4 py-3 text-slate-300 font-bold text-sm bg-slate-800/50 hover:bg-red-500/20 hover:text-red-300 rounded-xl transition duration-200">
                    🚪 Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 ml-72 flex flex-col min-h-screen">
        
        <!-- HEADER TOP BAR -->
        <header class="bg-white border-b border-slate-100 px-8 py-5 flex justify-between items-center sticky top-0 z-30 backdrop-blur-md bg-white/80 select-none">
            <div>
                <h1 class="text-xl font-black text-slate-900 tracking-tight">@yield('page-title', 'Admin Cabang Dashboard')</h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">PT Katiga Veritas Indonesia — Regional Access</p>
            </div>
            <div class="flex items-center gap-3">
                @if(session('success'))
                    <span class="text-sm font-semibold text-teal-700 bg-teal-50 border border-teal-200/60 px-3.5 py-1.5 rounded-xl shadow-sm animate-pulse">
                        ✅ {{ session('success') }}
                    </span>
                @endif
                @if(session('error'))
                    <span class="text-sm font-semibold text-red-700 bg-red-50 border border-red-200/60 px-3.5 py-1.5 rounded-xl shadow-sm animate-pulse">
                        ❌ {{ session('error') }}
                    </span>
                @endif
            </div>
        </header>

        <!-- PAGE BODY -->
        <main class="p-8 flex-1 bg-slate-50">
            @if($errors->any())
                <div class="mb-6 bg-red-50/70 border border-red-200/60 rounded-2xl p-4 backdrop-blur-sm">
                    <ul class="text-sm text-red-700 font-medium space-y-1">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    @stack('scripts')
</body>
</html>
