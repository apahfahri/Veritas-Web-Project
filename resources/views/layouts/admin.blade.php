<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | PT Katiga Veritas</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    @php
        $manifestPath = public_path('build/manifest.json');
        $manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : null;
        $jsFile = $manifest['resources/js/app.js']['file'] ?? null;
        $cssFiles = $manifest['resources/js/app.js']['css'] ?? [];
    @endphp
    @if($manifest && $jsFile)
        @foreach($cssFiles as $css)
            <link rel="stylesheet" href="{{ asset('build/' . $css) }}">
        @endforeach
        <script type="module" src="{{ asset('build/' . $jsFile) }}"></script>
    @else
        <script type="module" src="http://localhost:5173/resources/js/app.js"></script>
    @endif
    <style>
        body { font-family: 'Outfit', sans-serif; }
        @media (min-width: 1024px) {
            .sidebar-collapsed { width: 5.5rem !important; }
            .main-expanded { margin-left: 5.5rem !important; }
        }
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
    <aside id="sidebar" class="-translate-x-full lg:translate-x-0 w-72 h-screen bg-gradient-to-b from-slate-900 to-indigo-950 flex flex-col fixed top-0 left-0 z-40 shadow-2xl text-slate-100 transition-all duration-300 ease-in-out select-none">
        
        <!-- Logo -->
        <div class="p-6 border-b border-slate-800/80 flex items-center justify-between gap-3 shrink-0 relative">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Veritas Logo" class="w-11 h-11 object-contain shrink-0 bg-white rounded-xl shadow-lg shadow-cyan-500/10">
                <div class="sidebar-text">
                    <div class="font-extrabold text-base tracking-wide bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent truncate">Katiga Veritas</div>
                    <div class="text-xs text-cyan-400/90 font-medium tracking-wider uppercase truncate">Superadmin Panel</div>
                </div>
            </div>

            <!-- Minimize Button on Sidebar Edge -->
            <button id="sidebarToggle" class="absolute -right-3 top-8 w-6 h-6 bg-slate-800 text-slate-300 rounded-full flex items-center justify-center hover:bg-slate-700 hover:text-white hover:scale-110 transition shadow-lg z-50 border border-slate-700">
                <i class="fi fi-rr-angle-left transition-transform duration-300"></i>
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
                    <div class="text-xs text-orange-400 font-medium truncate">Superadmin</div>
                </div>
                <i class="fi fi-rr-angle-down text-slate-500 sidebar-text group-hover:text-slate-300 transition"></i>
            </div>
            
            <div id="profileDropdown" class="profile-dropdown px-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-xl transition text-sm font-bold">
                        <i class="fi fi-rr-sign-out-alt"></i>
                        <span class="sidebar-text">Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 py-3 space-y-1.5 overflow-y-auto min-h-0 pb-10">
            <div class="text-xs font-semibold text-slate-500 uppercase px-2 py-1 tracking-wider sidebar-text">Utama</div>
            
            <a href="{{ route('admin.dashboard') }}" 
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20' : 'text-slate-400' }}">
                <span class="shrink-0"><i class="fi fi-rr-apps"></i></span>
                <span class="sidebar-text truncate">Dashboard</span>
            </a>

            <a href="{{ route('admin.pendaftaran.index') }}" 
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('admin.pendaftaran.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20' : 'text-slate-400' }}">
                <span class="shrink-0"><i class="fi fi-rr-document"></i></span>
                <span class="sidebar-text truncate">Pendaftaran</span>
            </a>


            <a href="{{ route('admin.sertifikat.index') }}" 
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('admin.sertifikat.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20' : 'text-slate-400' }}">
                <span class="shrink-0"><i class="fi fi-rr-diploma"></i></span>
                <span class="sidebar-text truncate">Sertifikat</span>
            </a>

            <a href="{{ route('admin.laporan.index') }}" 
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('admin.laporan.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20' : 'text-slate-400' }}">
                <span class="shrink-0"><i class="fi fi-rr-chart-pie"></i></span>
                <span class="sidebar-text truncate">Laporan & Monitoring</span>
            </a>

            <div class="text-xs font-semibold text-slate-500 uppercase px-2 pt-4 py-1 tracking-wider sidebar-text">Kelola Data</div>

            <a href="{{ route('admin.jadwal.index') }}"
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('admin.jadwal.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20' : 'text-slate-400' }}">
                <span class="shrink-0"><i class="fi fi-rr-calendar"></i></span>
                <span class="sidebar-text truncate">Jadwal Pelatihan</span>
            </a>

            <a href="{{ route('admin.materi.index') }}"
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('admin.materi.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20' : 'text-slate-400' }}">
                <span class="shrink-0"><i class="fi fi-rr-book-alt"></i></span>
                <span class="sidebar-text truncate">Kelola Materi</span>
            </a>

            <a href="{{ route('admin.petugas.index') }}" 
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('admin.petugas.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20' : 'text-slate-400' }}">
                <span class="shrink-0"><i class="fi fi-rr-users"></i></span>
                <span class="sidebar-text truncate">Pemateri</span>
            </a>

            <a href="{{ route('admin.kategori.index') }}" 
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('admin.kategori.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20' : 'text-slate-400' }}">
                <span class="shrink-0"><i class="fi fi-rr-briefcase"></i></span>
                <span class="sidebar-text truncate">Kategori Layanan</span>
            </a>

            <a href="{{ route('admin.mitra.index') }}"
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('admin.mitra.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20' : 'text-slate-400' }}">
                <span class="shrink-0"><i class="fi fi-rr-building"></i></span>
                <span class="sidebar-text truncate">Daftar Perusahaan</span>
            </a>

            @if(Auth::user()->isSuperAdmin())
            <div class="text-xs font-semibold text-slate-500 uppercase px-2 pt-4 py-1 tracking-wider sidebar-text">Superadmin Tools</div>
            <a href="{{ route('admin.subadmin.index') }}" 
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('admin.subadmin.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20' : 'text-slate-400' }}">
                <span class="shrink-0"><i class="fi fi-rr-building"></i></span>
                <span class="sidebar-text truncate">Subadmin Management</span>
            </a>
            <a href="{{ route('admin.rekening.index') }}" 
               class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm {{ request()->routeIs('admin.rekening.*') ? 'bg-gradient-to-r from-cyan-600/90 to-teal-600/90 text-white shadow-lg shadow-cyan-600/20' : 'text-slate-400' }}">
                <span class="shrink-0"><i class="fi fi-rr-credit-card"></i></span>
                <span class="sidebar-text truncate">Kelola Rekening</span>
            </a>
            @endif

            <div class="text-xs font-semibold text-slate-500 uppercase px-2 pt-4 py-1 tracking-wider sidebar-text">Lainnya</div>
            <a href="{{ route('home') }}" class="group relative flex items-center gap-3.5 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 hover:text-white font-medium text-sm text-slate-400">
                <span class="shrink-0"><i class="fi fi-rr-globe"></i></span>
                <span class="sidebar-text truncate">Lihat Website</span>
            </a>
        </nav>

    </aside>

    <!-- MAIN CONTENT -->
    <div id="main-content" class="flex-1 ml-0 lg:ml-72 flex flex-col min-h-screen transition-all duration-300 ease-in-out">
        
        <!-- HEADER TOP BAR -->
        <header class="bg-white border-b border-slate-100 px-4 lg:px-8 py-5 flex justify-between items-center sticky top-0 z-30 backdrop-blur-md bg-white/80">
            <div class="flex items-center gap-3">
                <!-- Hamburger Menu Button (Mobile) -->
                <button id="mobileSidebarToggle" class="block lg:hidden text-slate-500 hover:text-slate-900 focus:outline-none p-1.5 rounded-lg hover:bg-slate-100 transition">
                    <i class="fi fi-rr-menu-burger"></i>
                </button>
                <div>
                    <h1 class="text-lg lg:text-xl font-black text-slate-900 tracking-tight">@yield('page-title', 'Admin Dashboard')</h1>
                    <p class="hidden sm:block text-[10px] lg:text-xs text-slate-500 font-medium mt-0.5">@yield('page-subtitle', 'PT Katiga Veritas Indonesia — Superadmin Access')</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @yield('header-actions')
                @if(session('success'))
                    <span class="text-sm font-semibold text-teal-700 bg-teal-50 border border-teal-200/60 px-3.5 py-1.5 rounded-xl shadow-sm flex items-center gap-1.5">
                        <i class="fi fi-rr-check"></i>
                        {{ session('success') }}
                    </span>
                @endif
                @if(session('warning'))
                    <button onclick="Swal.fire({title: 'Peringatan Import', html: `<div class='text-left text-sm max-h-60 overflow-y-auto space-y-1'>{!! str_replace("\n", '<br>', addslashes(e(session('warning')))) !!}</div>`, icon: 'warning', confirmButtonColor: '#0f172a', customClass: {popup: 'rounded-[32px]'}})" 
                            class="text-sm font-semibold text-amber-700 bg-amber-50 border border-amber-200/60 px-3.5 py-1.5 rounded-xl shadow-sm flex items-center gap-1.5 hover:bg-amber-100/50 transition">
                        <i class="fi fi-rr-triangle-warning text-amber-500"></i>
                        Import Warning (Klik Detail)
                    </button>
                @endif
                @if(session('error'))
                    <button onclick="Swal.fire({title: 'Gagal Import', html: `<div class='text-left text-sm max-h-60 overflow-y-auto space-y-1'>{!! str_replace("\n", '<br>', addslashes(e(session('error')))) !!}</div>`, icon: 'error', confirmButtonColor: '#0f172a', customClass: {popup: 'rounded-[32px]'}})" 
                            class="text-sm font-semibold text-rose-700 bg-rose-50 border border-rose-200/60 px-3.5 py-1.5 rounded-xl shadow-sm flex items-center gap-1.5 hover:bg-rose-100/50 transition">
                        <i class="fi fi-rr-cross-circle text-rose-500"></i>
                        Import Gagal (Klik Detail)
                    </button>
                @endif
            </div>
        </header>

        <!-- PAGE BODY -->
        <main class="p-8 flex-1 bg-slate-50">
            @if($errors->any())
                <div class="mb-6 bg-red-50/70 border border-red-200/60 rounded-2xl p-4 backdrop-blur-sm">
                    <ul class="text-sm text-red-700 font-medium space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="flex items-start gap-1.5">
                                <i class="fi fi-rr-cross-circle mt-0.5"></i>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
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

            // Mobile Sidebar Toggle
            const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
            const backdrop = document.createElement('div');
            backdrop.className = 'fixed inset-0 bg-slate-950/40 backdrop-blur-sm z-30 opacity-0 pointer-events-none transition-opacity duration-300 lg:hidden';
            document.body.appendChild(backdrop);

            function openMobileSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                backdrop.classList.add('opacity-100', 'pointer-events-auto');
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
            }

            function closeMobileSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
                backdrop.classList.remove('opacity-100', 'pointer-events-auto');
            }

            if (mobileSidebarToggle) {
                mobileSidebarToggle.addEventListener('click', openMobileSidebar);
            }
            backdrop.addEventListener('click', closeMobileSidebar);

            // Close mobile sidebar on page navigation click (if on mobile)
            const sidebarLinks = sidebar.querySelectorAll('nav a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        closeMobileSidebar();
                    }
                });
            });

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
                    toggleIcon.style.transform = sidebar.classList.contains('sidebar-collapsed') ? 'rotate(180deg)' : '';
                    
                    localStorage.setItem('adminSidebarCollapsed', sidebar.classList.contains('sidebar-collapsed'));
                    tooltip.style.opacity = '0'; // hide tooltip when toggling
                });

                // Restore state
                if (localStorage.getItem('adminSidebarCollapsed') === 'true') {
                    sidebar.classList.add('sidebar-collapsed');
                    mainContent.classList.add('main-expanded');
                    sidebarTexts.forEach(t => t.classList.add('hide-text'));
                    toggleIcon.style.transform = 'rotate(180deg)';
                }
            }

            if (profileToggle) {
                profileToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('show');
                });
            }

            document.addEventListener('click', () => {
                if (profileDropdown) profileDropdown.classList.remove('show');
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert2 Global Delete Confirmation
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const name = this.getAttribute('data-name') || 'item ini';
                    
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: `Anda akan menghapus "${name}". Tindakan ini tidak dapat dibatalkan!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#0f172a',
                        cancelButtonColor: '#94a3b8',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        borderRadios: '20px',
                        customClass: {
                            popup: 'rounded-[32px]',
                            confirmButton: 'rounded-xl font-black uppercase tracking-widest text-xs px-6 py-3',
                            cancelButton: 'rounded-xl font-black uppercase tracking-widest text-xs px-6 py-3'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
