<header class="sticky top-0 z-50 bg-white border-b shadow-sm">
    <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">

            <!-- Logo -->
            <a href="/" class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-[#7d2ae7] to-[#07b9ce] text-white shadow-sm">
                    🛡️
                </div>
                <div class="hidden sm:block">
                    <div class="font-bold text-lg text-[#7d2ae7]">
                        PT Katiga Veritas
                    </div>
                    <div class="text-xs text-gray-500">
                        Solusi K3 Profesional
                    </div>
                </div>
            </a>

            <!-- Navigation -->
            <div class="hidden lg:flex gap-4">
                <a href="/" class="px-3 py-2 hover:text-[#7d2ae7] transition-colors font-medium">Beranda</a>
                
                <!-- Layanan Dropdown -->
                <div class="relative group">
                    <button class="px-3 py-2 flex items-center gap-1 hover:text-[#7d2ae7] transition-colors font-medium">
                        Layanan
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-[#7d2ae7] transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="absolute left-0 mt-0 w-48 bg-white rounded-xl shadow-xl border border-gray-100 py-2 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-300 z-50 translate-y-2 group-hover:translate-y-0">
                        <a href="/training" class="block px-4 py-2 hover:bg-[#7d2ae7]/10 hover:text-[#7d2ae7] transition-colors">Pelatihan</a>
                        <a href="/consultation" class="block px-4 py-2 hover:bg-[#7d2ae7]/10 hover:text-[#7d2ae7] transition-colors">Konsultasi</a>
                        <a href="/audit" class="block px-4 py-2 hover:bg-[#7d2ae7]/10 hover:text-[#7d2ae7] transition-colors">Audit</a>
                    </div>
                </div>

                <a href="{{ route('training.status') }}" class="px-3 py-2 hover:text-[#7d2ae7] transition-colors font-medium">Cek Status</a>
                <a href="/verification" class="px-3 py-2 hover:text-[#7d2ae7] transition-colors font-medium">Verifikasi</a>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden lg:flex items-center gap-2">


                @auth
                    <!-- Sudah login: tampilkan dropdown profil -->
                    <div class="relative">
                        <button id="profile-menu-button" class="flex items-center gap-3 focus:outline-none group">
                            {{-- Avatar --}}
                            <div class="w-10 h-10 rounded-full bg-[#7d2ae7] flex items-center justify-center text-white text-sm font-bold shadow-sm group-hover:scale-105 transition-transform">
                                {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                            </div>

                            <div class="hidden sm:flex flex-col items-start text-left">
                                <span class="text-sm font-bold text-gray-800 leading-tight">
                                    {{ Auth::user()->username }}
                                </span>
                                <span class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">
                                    Admin
                                </span>
                            </div>
                            
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#7d2ae7] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profile-dropdown" class="absolute right-0 mt-3 w-60 bg-white rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.15)] border border-gray-100 py-2 hidden z-50 overflow-hidden">
                            
                            <div class="p-2">
                                <a href="{{ Auth::user()->isSubadmin() ? route('subadmin.dashboard') : route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-xl transition-all group/item">
                                    <span class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-xl group-hover/item:bg-[#7d2ae7]/10 group-hover/item:text-[#7d2ae7] transition-all text-lg">📊</span>
                                    <div class="flex flex-col">
                                        <span class="font-bold">Dashboard Admin</span>
                                        <span class="text-[10px] text-gray-400">Kelola sistem</span>
                                    </div>
                                </a>

                                <div class="my-2 border-t border-gray-50"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-3 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-all group/item">
                                        <span class="w-10 h-10 flex items-center justify-center bg-red-50 rounded-xl group-hover/item:bg-red-600 group-hover/item:text-white transition-all text-lg">🚪</span>
                                        <span class="font-bold">Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        (function() {
                            const btn = document.getElementById('profile-menu-button');
                            const dropdown = document.getElementById('profile-dropdown');

                            if (btn && dropdown) {
                                btn.addEventListener('click', function(e) {
                                    e.stopPropagation();
                                    dropdown.classList.toggle('hidden');
                                });

                                document.addEventListener('click', function(e) {
                                    if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
                                        dropdown.classList.add('hidden');
                                    }
                                });
                            }
                        })();
                    </script>
                @endauth
            </div>

        </div>
    </nav>
</header>