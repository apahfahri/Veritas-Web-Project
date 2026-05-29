<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Subadmin') Katiga Veritas</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .sidebar-collapsed { width: 5.5rem !important; }
        .main-expanded { margin-left: 5.5rem !important; }
        .hide-text { display: none !important; }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.3); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(148, 163, 184, 0.5); }
        .profile-dropdown { transition: all 0.2s ease-in-out; max-height: 0; overflow: hidden; opacity: 0; }
        .profile-dropdown.show { max-height: 200px; opacity: 1; margin-top: 0.5rem; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-50 flex text-slate-800">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="w-72 h-screen bg-gradient-to-b from-slate-900 to-indigo-950 flex flex-col fixed top-0 left-0 z-40 shadow-2xl text-slate-100 transition-all duration-300 ease-in-out select-none">
        
        <!-- Logo -->
        <div class="p-6 border-b border-slate-800/80 flex items-center justify-between gap-3 shrink-0 relative">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Veritas Logo" class="w-11 h-11 object-contain shrink-0 bg-white rounded-xl shadow-lg shadow-cyan-500/10">
                <div class="sidebar-text">
                    <div class="font-extrabold text-base tracking-wide bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent truncate">Katiga Veritas</div>
                    <div class="text-xs text-cyan-400/90 font-medium tracking-wider uppercase truncate">Subadmin Panel</div>
                </div>
            </div>

            <!-- Minimize Button on Sidebar Edge -->
            <button id="sidebarToggle" class="absolute -right-3 top-8 w-6 h-6 bg-slate-800 text-slate-300 rounded-full flex items-center justify-center hover:bg-slate-700 hover:text-white hover:scale-110 transition shadow-lg z-50 border border-slate-700">
                <svg class="w-3 h-3 transition-transform duration-300" id="sidebarToggleIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
        </div>

        <!-- User Profile Card -->
        <div class="px-3 py-4 border-b border-slate-800/80 shrink-0">
            <div id="profileToggle" class="flex items-center gap-3 px-3 py-3 rounded-xl bg-slate-800/40 backdrop-blur-sm cursor-pointer hover:bg-slate-800/60 transition group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-slate-950 text-sm font-black shadow-md shadow-orange-500/20 shrink-0 group-hover:scale-105 transition">
                    {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                </div>
                <div class="overflow-hidden sidebar-text flex-1">
                    <div class="text-white text-sm font-bold truncate">{{ Auth::user()->username }}</div>
                    <div class="text-xs text-orange-400 font-medium truncate">Subadmin</div>
                </div>
                <svg class="w-4 h-4 text-slate-500 sidebar-text group-hover:text-slate-300 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
            
            <div id="profileDropdown" class="profile-dropdown px-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-xl transition text-sm font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="sidebar-text">Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-3 space-y-1.5 overflow-y-auto min-h-0 pb-20 custom-scrollbar">
            <div class="text-xs font-semibold text-slate-500 uppercase px-2 py-1 tracking-wider sidebar-text">Utama</div>
            
            <a href="{{ route('subadmin.dashboard') }}" 
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('subadmin.dashboard') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20 active' : 'text-slate-400' }}">
                <span class="shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg></span>
                <span class="sidebar-text truncate">Dashboard</span>
            </a>

            <!-- PELATIHAN GROUP -->
            <div class="text-xs font-semibold text-slate-500 uppercase px-2 pt-5 py-1 tracking-wider sidebar-text">Pelatihan</div>

            <a href="{{ route('subadmin.jadwal.index') }}"
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('subadmin.jadwal.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20 active' : 'text-slate-400' }}">
                <span class="shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"/></svg></span>
                <span class="sidebar-text truncate">Jadwal Pelatihan</span>
            </a>

            <a href="{{ route('subadmin.pendaftaran.index') }}" 
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ (request()->routeIs('subadmin.pendaftaran.*') && !request('context')) ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20 active' : 'text-slate-400' }}">
                <span class="shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg></span>
                <span class="sidebar-text truncate">Pendaftaran Pelatihan</span>
            </a>

            <a href="{{ route('subadmin.materi.index') }}"
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('subadmin.materi.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20 active' : 'text-slate-400' }}">
                <span class="shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></span>
                <span class="sidebar-text truncate">Kelola Materi</span>
            </a>

            <!-- KONSULTASI GROUP -->
            <div class="text-xs font-semibold text-slate-500 uppercase px-2 pt-5 py-1 tracking-wider sidebar-text">Konsultasi</div>

            <a href="{{ route('subadmin.konsultasi.index') }}"
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('subadmin.konsultasi.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20 active' : 'text-slate-400' }}">
                <span class="shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg></span>
                <span class="sidebar-text truncate">Layanan Konsultasi</span>
            </a>

            <!-- DATA & REFERENSI GROUP -->
            <div class="text-xs font-semibold text-slate-500 uppercase px-2 pt-5 py-1 tracking-wider sidebar-text">Data & Referensi</div>

            <a href="{{ route('subadmin.perusahaan.index') }}" 
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('subadmin.perusahaan.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20 active' : 'text-slate-400' }}">
                <span class="shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></span>
                <span class="sidebar-text truncate">Daftar Perusahaan</span>
            </a>


            <a href="{{ route('subadmin.petugas.index') }}" 
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('subadmin.petugas.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20 active' : 'text-slate-400' }}">
                <span class="shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></span>
                <span class="sidebar-text truncate">Daftar Pemateri</span>
            </a>

            <a href="{{ route('subadmin.sertifikat.index') }}" 
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('subadmin.sertifikat.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20 active' : 'text-slate-400' }}">
                <span class="shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg></span>
                <span class="sidebar-text truncate">Sertifikat</span>
            </a>
        </nav>

    </aside>

    <!-- MAIN CONTENT -->
    <div id="main-content" class="flex-1 ml-72 flex flex-col min-h-screen transition-all duration-300 ease-in-out">
        
        <!-- HEADER TOP BAR -->
        <header class="bg-white border-b border-slate-100 px-8 py-5 flex justify-between items-center sticky top-0 z-30 backdrop-blur-md bg-white/80 select-none">
            <div class="flex items-center gap-4">
                <div>
                    <h1 class="text-xl font-black text-slate-900 tracking-tight">@yield('page-title', 'Subadmin Dashboard')</h1>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">PT Katiga Veritas Indonesia | Subadmin Access</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                @yield('header-actions')
                <div class="h-8 w-px bg-slate-100 mx-2"></div>
                @if(session('success'))
                    <span class="text-sm font-semibold text-teal-700 bg-teal-50 border border-teal-200/60 px-3.5 py-1.5 rounded-xl shadow-sm flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </span>
                @endif
                @if(session('error'))
                    <span class="text-sm font-semibold text-red-700 bg-red-50 border border-red-200/60 px-3.5 py-1.5 rounded-xl shadow-sm flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        {{ session('error') }}
                    </span>
                @endif
            </div>
        </header>

        <!-- PAGE BODY -->
        <main class="p-8 flex-1 bg-slate-50" id="main-scroll-area">
            @if($errors->any())
                <div class="mb-6 bg-red-50/70 border border-red-200/60 rounded-2xl p-4 backdrop-blur-sm">
                    <ul class="text-sm text-red-700 font-medium space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="flex items-start gap-1.5">
                                <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div id="export-container">
                @yield('content')
            </div>
        </main>

    </div>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const toggleBtn = document.getElementById('sidebarToggle');
            const toggleIcon = document.getElementById('sidebarToggleIcon');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            const profileToggle = document.getElementById('profileToggle');
            const profileDropdown = document.getElementById('profileDropdown');

            // Global Tooltip Logic
            const tooltip = document.createElement('div');
            tooltip.className = 'fixed bg-slate-800 text-white text-xs font-bold px-3 py-2 rounded-lg shadow-lg pointer-events-none opacity-0 transition-opacity duration-200 z-[100] border border-slate-700/50 whitespace-nowrap';
            document.body.appendChild(tooltip);

            const navLinks = document.querySelectorAll('#sidebar nav a');
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', () => {
                    if (sidebar.classList.contains('sidebar-collapsed')) {
                        const textEl = link.querySelector('.sidebar-text');
                        if(textEl) {
                            tooltip.innerText = textEl.innerText;
                            const rect = link.getBoundingClientRect();
                            tooltip.style.left = (rect.right + 10) + 'px';
                            tooltip.style.top = (rect.top + (rect.height / 2) - 14) + 'px'; // center vertically
                            tooltip.style.opacity = '1';
                        }
                    }
                });
                link.addEventListener('mouseleave', () => {
                    tooltip.style.opacity = '0';
                });
            });

            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('sidebar-collapsed');
                    mainContent.classList.toggle('main-expanded');
                    sidebarTexts.forEach(t => t.classList.toggle('hide-text'));
                    if(toggleIcon) toggleIcon.style.transform = sidebar.classList.contains('sidebar-collapsed') ? 'rotate(180deg)' : '';
                    
                    localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('sidebar-collapsed'));
                    tooltip.style.opacity = '0'; // hide tooltip when toggling
                });
            }

            profileToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                profileDropdown.classList.toggle('show');
            });

            document.addEventListener('click', () => {
                profileDropdown.classList.remove('show');
            });

            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (isCollapsed) {
                sidebar.classList.add('sidebar-collapsed');
                mainContent.classList.add('main-expanded');
                sidebarTexts.forEach(t => t.classList.add('hide-text'));
                if(toggleIcon) toggleIcon.style.transform = 'rotate(180deg)';
            }
        });
    </script>
</body>
</html>

