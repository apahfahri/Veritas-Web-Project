<header class="sticky top-0 z-50 bg-white border-b shadow-sm">
    <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">

            <!-- Logo -->
            <a href="/" class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-900 text-white">
                    🛡️
                </div>
                <div class="hidden sm:block">
                    <div class="font-bold text-lg text-blue-900">
                        PT Katiga Veritas
                    </div>
                    <div class="text-xs text-gray-500">
                        Solusi K3 Profesional
                    </div>
                </div>
            </a>

            <!-- Navigation -->
            <div class="hidden lg:flex gap-4">
                <a href="/" class="px-3 py-2">Beranda</a>
                <a href="/training" class="px-3 py-2">Pelatihan</a>
                <a href="/consultation" class="px-3 py-2">Konsultasi</a>
                <a href="/audit" class="px-3 py-2">Audit</a>
                <a href="/verification" class="px-3 py-2">Verifikasi</a>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden lg:flex items-center gap-2">

                @guest
                    <!-- Belum login: tampilkan Login & Register -->
                    <a href="{{ route('login') }}"
                       class="border border-gray-300 px-4 py-2 rounded hover:bg-gray-100 text-sm font-medium">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                       class="bg-[#FF7A00] text-white px-4 py-2 rounded hover:opacity-90 text-sm font-medium">
                        Register
                    </a>
                @endguest

                @auth
                    <!-- Sudah login: tampilkan nama user + avatar + Logout -->
                    <div class="flex items-center gap-3">

                        {{-- Avatar --}}
                        @if (Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}"
                                 alt="{{ Auth::user()->name }}"
                                 class="w-8 h-8 rounded-full object-cover border border-gray-200">
                        @else
                            <div class="w-8 h-8 rounded-full bg-[#00A8A8] flex items-center justify-center text-white text-sm font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif

                        {{-- Nama user --}}
                        <span class="text-sm font-medium text-gray-700">
                            {{ Auth::user()->name }}
                        </span>

                        {{-- Link Dashboard --}}
                        <a href="{{ route('dashboard') }}"
                           class="border px-3 py-1.5 rounded text-sm hover:bg-gray-50">
                            Dashboard
                        </a>

                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-sm transition">
                                Logout
                            </button>
                        </form>
                    </div>
                @endauth

            </div>

        </div>
    </nav>
</header>