<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — PT Katiga Veritas</title>
    <script type="module" src="http://localhost:5173/resources/js/app.js"></script>
    <style>
        .sidebar-link { display:flex; align-items:center; gap:10px; padding:10px 16px; border-radius:8px; color:#cbd5e1; text-decoration:none; transition:all .2s; font-size:14px; }
        .sidebar-link:hover, .sidebar-link.active { background:rgba(255,255,255,.1); color:#fff; }
        .badge { display:inline-block; font-size:11px; padding:2px 8px; border-radius:9999px; font-weight:600; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-[#F5F7FA] flex">

    <!-- SIDEBAR -->
    <aside class="w-64 min-h-screen bg-[#0A2540] flex flex-col fixed top-0 left-0 z-40">

        <!-- Logo -->
        <div class="p-6 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#00A8A8] rounded-xl flex items-center justify-center text-white font-bold">K</div>
                <div>
                    <div class="text-white font-bold text-sm">Katiga Veritas</div>
                    <div class="text-xs text-slate-400">Admin Panel</div>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="px-4 py-3 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-[#FF7A00] flex items-center justify-center text-white text-xs font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="text-white text-sm font-medium">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-400">
                        {{ Auth::user()->admin?->role === 'superadmin' ? 'Super Admin' : 'Admin' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-3 space-y-1 overflow-y-auto">

            <div class="text-xs font-semibold text-slate-500 uppercase px-2 mb-2 mt-2">Utama</div>

            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                📊 Dashboard
            </a>

            <a href="{{ route('admin.pendaftaran.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pendaftaran.*') ? 'active' : '' }}">
                📋 Pendaftaran
            </a>

            <a href="{{ route('admin.sertifikat.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.sertifikat.*') ? 'active' : '' }}">
                🏆 Sertifikat
            </a>

            <div class="text-xs font-semibold text-slate-500 uppercase px-2 mb-2 mt-4">Kelola Data</div>

            <a href="{{ route('admin.pelatihan.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.pelatihan.*') ? 'active' : '' }}">
                🎓 Pelatihan
            </a>

            <a href="{{ route('admin.petugas.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.petugas.*') ? 'active' : '' }}">
                👥 Petugas
            </a>

            @if(Auth::user()->isSuperAdmin())
            <a href="{{ route('admin.admin-cabang.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.admin-cabang.*') ? 'active' : '' }}">
                🏢 Admin Cabang
            </a>
            @endif

            <div class="text-xs font-semibold text-slate-500 uppercase px-2 mb-2 mt-4">Lainnya</div>

            <a href="{{ route('home') }}" class="sidebar-link">🌐 Lihat Website</a>

        </nav>

        <!-- Logout -->
        <div class="p-3 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full sidebar-link hover:bg-red-500/20 hover:text-red-300">
                    🚪 Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 ml-64">

        <!-- TOP BAR -->
        <header class="bg-white border-b px-6 py-4 flex justify-between items-center sticky top-0 z-30">
            <div>
                <h1 class="text-lg font-bold text-[#0A2540]">@yield('page-title', 'Admin Panel')</h1>
                <p class="text-xs text-gray-500">@yield('page-subtitle', 'PT Katiga Veritas Indonesia')</p>
            </div>
            <div class="flex items-center gap-3">
                @if(session('success'))
                    <span class="text-sm text-green-600 bg-green-50 px-3 py-1 rounded-full">
                        ✅ {{ session('success') }}
                    </span>
                @endif
                @if(session('error'))
                    <span class="text-sm text-red-600 bg-red-50 px-3 py-1 rounded-full">
                        ❌ {{ session('error') }}
                    </span>
                @endif
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="p-6">
            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
                    <ul class="text-sm text-red-700 space-y-1">
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
