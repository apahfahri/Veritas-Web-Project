@extends('layouts.app')

@section('content')

<!-- HERO -->
<section class="relative bg-white overflow-hidden min-h-[70vh] flex items-center">
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-br from-[#1E6B3D] to-[#3CDA7D] clip-path-hero hidden lg:block"></div>
    <div class="absolute top-[-10%] left-[-5%] w-64 h-64 bg-[#3CDA7D]/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[10%] right-[10%] w-96 h-96 bg-[#1E6B3D]/5 rounded-full blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-6 py-12 lg:py-0 grid lg:grid-cols-[1.1fr_0.9fr] gap-12 items-center">
        <div class="space-y-8 animate-fade-in-up">
            <div class="mt-6 inline-flex items-center gap-2 bg-[#1E6B3D]/10 text-[#1E6B3D] px-4 py-2 rounded-full text-sm font-semibold tracking-wide">
                <span class="flex h-2 w-2 rounded-full bg-[#1E6B3D] animate-pulse"></span>
                Terpercaya & Bersertifikat Resmi
            </div>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-[1.1]">
                Solusi <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1E6B3D] to-[#3CDA7D]">K3 Profesional</span> Untuk Bisnis Anda
            </h1>

            <p class="text-base text-gray-600 leading-relaxed max-w-xl">
                Wujudkan lingkungan kerja yang aman dan produktif dengan layanan pelatihan, konsultasi, dan audit K3 berstandar nasional.
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="/training" class="bg-gradient-to-r from-[#1E6B3D] to-[#3CDA7D] text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-[#1E6B3D]/20 hover:scale-105 transition-all flex items-center gap-2">
                    🎓 Mulai Pelatihan
                </a>
                <a href="/consultation" class="bg-white text-gray-700 border-2 border-gray-100 px-8 py-4 rounded-2xl font-bold hover:bg-gray-50 transition-all flex items-center gap-2">
                    💬 Konsultasi Gratis
                </a>
            </div>

            <div class="pt-2 grid grid-cols-3 gap-6 border-t border-gray-100">
                <div>
                    <div class="text-3xl font-black text-[#1E6B3D]">1K+</div>
                    <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Peserta Terlatih</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-[#1E6B3D]">50+</div>
                    <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Mitra Korporat</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-[#1E6B3D]">15+</div>
                    <div class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Tahun Pengalaman</div>
                </div>
            </div>
        </div>

        <div class="relative lg:block hidden max-w-sm ml-auto">
            <div class="absolute -inset-4 bg-gradient-to-r from-[#1E6B3D] to-[#3CDA7D] rounded-[2rem] rotate-3 opacity-20 blur-lg"></div>
            <div class="relative bg-white p-3 rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100">
                <img src="https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?q=80&w=2070&auto=format&fit=crop"
                     alt="K3 Professional"
                     class="rounded-[2rem] w-full object-cover aspect-[4/5]">
            </div>
            <!-- Floating Card -->
            <div class="absolute -bottom-6 -left-10 bg-white p-6 rounded-2xl shadow-xl border border-gray-50 animate-bounce-slow">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-2xl">✅</div>
                    <div>
                        <div class="font-bold text-gray-900">Sertifikasi Resmi</div>
                        <div class="text-sm text-gray-500">BNSP & Kemnaker</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .clip-path-hero {
        clip-path: polygon(25% 0%, 100% 0%, 100% 100%, 0% 100%);
    }
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-bounce-slow {
        animation: bounce-slow 4s infinite ease-in-out;
    }
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fade-in-up 1s ease-out;
    }
</style>


<!-- SERVICES -->
<section class="py-16 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-xs font-bold text-[#1E6B3D] uppercase tracking-[0.2em] mb-3">Layanan Utama</h2>
            <h3 class="text-3xl md:text-4xl font-black text-gray-900">Solusi K3 Terintegrasi</h3>
            <p class="mt-4 text-gray-500 max-w-2xl mx-auto text-base">
                Kami menyediakan ekosistem keselamatan kerja yang komprehensif untuk mendukung keberlanjutan bisnis Anda.
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-10">
            <!-- Pelatihan -->
            <div class="group bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500">🎓</div>
                <h4 class="text-xl font-bold mb-3 text-gray-900">Pelatihan K3</h4>
                <p class="text-sm text-gray-500 leading-relaxed mb-6">
                    Sertifikasi resmi BNSP & Kemnaker dengan instruktur praktisi berpengalaman di bidangnya.
                </p>
                <a href="/training" class="text-[#1E6B3D] font-bold flex items-center gap-2 group/link">
                    Selengkapnya <span class="group-hover/link:translate-x-2 transition-transform">→</span>
                </a>
            </div>

            <!-- Konsultasi -->
            <div class="group bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500">👥</div>
                <h4 class="text-xl font-bold mb-3 text-gray-900">Konsultasi</h4>
                <p class="text-sm text-gray-500 leading-relaxed mb-6">
                    Pendampingan ahli dalam implementasi SMK3, ISO 45001, dan kepatuhan regulasi keselamatan kerja.
                </p>
                <a href="/consultation" class="text-[#1E6B3D] font-bold flex items-center gap-2 group/link">
                    Selengkapnya <span class="group-hover/link:translate-x-2 transition-transform">→</span>
                </a>
            </div>

            <!-- Audit -->
            <div class="group bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                <div class="w-16 h-16 bg-teal-50 rounded-2xl flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500">📋</div>
                <h4 class="text-xl font-bold mb-3 text-gray-900">Audit K3</h4>
                <p class="text-sm text-gray-500 leading-relaxed mb-6">
                    Penilaian independen terhadap efektivitas sistem manajemen keselamatan di lingkungan kerja Anda.
                </p>
                <a href="/audit" class="text-[#1E6B3D] font-bold flex items-center gap-2 group/link">
                    Selengkapnya <span class="group-hover/link:translate-x-2 transition-transform">→</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- WHY US -->
<section class="py-16 bg-[#F5F7FA] relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-20 bg-white clip-path-divider"></div>
    
    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">
        <div>
            <h2 class="text-xs font-bold text-[#1E6B3D] uppercase tracking-[0.2em] mb-4">Keunggulan Kami</h2>
            <h3 class="text-3xl md:text-4xl font-black text-gray-900 leading-tight mb-6">Mengapa Memilih PT Katiga Veritas?</h3>
            
            <div class="space-y-8">
                <div class="flex gap-6">
                    <div class="w-14 h-14 shrink-0 bg-white rounded-2xl shadow-sm flex items-center justify-center text-2xl">🛡️</div>
                    <div>
                        <h5 class="text-xl font-bold mb-1">Integritas & Amanah</h5>
                        <p class="text-gray-500">Kami menjunjung tinggi kejujuran dan transparansi dalam setiap layanan yang kami berikan.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="w-14 h-14 shrink-0 bg-white rounded-2xl shadow-sm flex items-center justify-center text-2xl">🏆</div>
                    <div>
                        <h5 class="text-xl font-bold mb-1">Tenaga Ahli Profesional</h5>
                        <p class="text-gray-500">Didukung oleh tim konsultan dan instruktur yang bersertifikat dan praktisi di industri.</p>
                    </div>
                </div>
                <div class="flex gap-6">
                    <div class="w-14 h-14 shrink-0 bg-white rounded-2xl shadow-sm flex items-center justify-center text-2xl">📈</div>
                    <div>
                        <h5 class="text-xl font-bold mb-1">Prinsip Syariah</h5>
                        <p class="text-gray-500">Satu-satunya penyedia jasa K3 yang mengedepankan nilai-nilai syariah dalam bermuamalah.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 max-w-lg ml-auto">
            <div class="space-y-4 pt-12">
                <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=2070&auto=format&fit=crop" class="rounded-2xl shadow-lg w-full h-56 object-cover">
                <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=2070&auto=format&fit=crop" class="rounded-2xl shadow-lg w-full h-40 object-cover">
            </div>
            <div class="space-y-4">
                <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?q=80&w=2070&auto=format&fit=crop" class="rounded-2xl shadow-lg w-full h-40 object-cover">
                <img src="https://images.unsplash.com/photo-1513530534585-c7b1394c6d51?q=80&w=2071&auto=format&fit=crop" class="rounded-2xl shadow-lg w-full h-56 object-cover">
            </div>
        </div>
    </div>
</section>

<!-- EXPERTS CAROUSEL -->
<section class="py-16 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
            <div>
                <h2 class="text-xs font-bold text-[#1E6B3D] uppercase tracking-[0.2em] mb-3">Tim Ahli Kami</h2>
                <h3 class="text-3xl font-black text-gray-900">Dipandu Oleh Praktisi Terbaik</h3>
            </div>
            <div class="flex gap-2">
                <button onclick="scrollExperts('left')" class="w-12 h-12 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-[#1E6B3D] hover:text-white transition-all shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button onclick="scrollExperts('right')" class="w-12 h-12 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-[#1E6B3D] hover:text-white transition-all shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <div id="experts-container" class="flex gap-6 overflow-x-auto pb-8 snap-x no-scrollbar scroll-smooth">
            @forelse($pemateris as $expert)
                <div class="min-w-[170px] md:min-w-[220px] snap-center group">
                    <div class="relative overflow-hidden rounded-[2rem] mb-6">
                        <img src="{{ $expert->foto ?? 'https://via.placeholder.com/300x400?text=No+Photo' }}" 
                             alt="{{ $expert->nama_lengkap }}" 
                             class="w-full aspect-[3/4] object-cover group-hover:scale-110 transition-transform duration-500">
                        @if($expert->bio)
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1E6B3D]/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-6">
                            <p class="text-white text-xs leading-relaxed">{{ $expert->bio }}</p>
                        </div>
                        @endif
                    </div>
                    <h4 class="text-lg font-bold text-gray-900 leading-tight mb-1">{{ $expert->nama_lengkap }}</h4>
                    <p class="text-[#1E6B3D] font-semibold text-[11px] uppercase tracking-wider">{{ $expert->kompetensi }}</p>
                </div>
            @empty
                <div class="w-full text-center py-10 text-gray-400">
                    Belum ada data pemateri.
                </div>
            @endforelse
        </div>
    </div>
</section>

<script>
    function scrollExperts(direction) {
        const container = document.getElementById('experts-container');
        const scrollAmount = 350;
        if (direction === 'left') {
            container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        } else {
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }
</script>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .clip-path-divider {
        clip-path: polygon(0 0, 100% 0, 100% 100%, 0 0);
    }
</style>


<!-- TESTIMONIALS -->
<section class="py-16 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-xs font-bold text-[#1E6B3D] uppercase tracking-[0.2em] mb-3">Testimonial</h2>
            <h3 class="text-3xl font-black text-gray-900">Apa Kata Mereka?</h3>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-[#F9FAFB] p-8 rounded-[2rem] relative">
                <div class="text-[#1E6B3D] text-5xl absolute top-6 right-8 opacity-10 font-serif">"</div>
                <div class="flex gap-1 text-yellow-400 mb-5">⭐⭐⭐⭐⭐</div>
                <p class="text-gray-600 mb-6 leading-relaxed italic text-base">
                    "Instrukturnya sangat kompeten dan materi yang diberikan sangat relevan dengan kebutuhan industri saat ini."
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-400">B</div>
                    <div>
                        <div class="font-bold text-gray-900">Budi Santoso</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider">HSE Manager - PT Konstruksi Jaya</div>
                    </div>
                </div>
            </div>

            <div class="bg-[#F9FAFB] p-8 rounded-[2rem] relative">
                <div class="text-[#1E6B3D] text-5xl absolute top-6 right-8 opacity-10 font-serif">"</div>
                <div class="flex gap-1 text-yellow-400 mb-5">⭐⭐⭐⭐⭐</div>
                <p class="text-gray-600 mb-6 leading-relaxed italic text-base">
                    "Proses pendaftaran mudah dan verifikasi sertifikatnya sangat cepat. Sangat profesional!"
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-400">A</div>
                    <div>
                        <div class="font-bold text-gray-900">Andi Wijaya</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider">Safety Officer - PT Energi Abadi</div>
                    </div>
                </div>
            </div>

            <div class="bg-[#F9FAFB] p-8 rounded-[2rem] relative">
                <div class="text-[#1E6B3D] text-5xl absolute top-6 right-8 opacity-10 font-serif">"</div>
                <div class="flex gap-1 text-yellow-400 mb-5">⭐⭐⭐⭐⭐</div>
                <p class="text-gray-600 mb-6 leading-relaxed italic text-base">
                    "Layanan konsultasi SMK3-nya sangat mendalam dan membantu kami meraih sertifikasi dengan lancar."
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-400">S</div>
                    <div>
                        <div class="font-bold text-gray-900">Sari Rahayu</div>
                        <div class="text-xs text-gray-400 uppercase tracking-wider">HR Manager - PT Manufaktur Sejahtera</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="bg-gradient-to-r from-[#1E6B3D] to-[#3CDA7D] rounded-[2rem] p-10 md:p-16 text-center relative overflow-hidden shadow-2xl">
            <!-- Decorative circle -->
            <div class="absolute top-[-50%] right-[-10%] w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-[-50%] left-[-10%] w-96 h-96 bg-black/10 rounded-full blur-3xl"></div>

            <div class="relative z-10 space-y-6">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-black text-white leading-tight">
                    Siap Meningkatkan Standar <br class="hidden md:block"> Keselamatan Kerja?
                </h2>
                <p class="text-white/80 text-lg max-w-2xl mx-auto">
                    Bergabunglah dengan ratusan perusahaan yang telah mempercayakan aspek K3 mereka kepada kami.
                </p>
                <div class="flex flex-wrap justify-center gap-4 pt-4">
                    <a href="https://wa.me/6281234567890" target="_blank" class="bg-white text-[#1E6B3D] px-10 py-5 rounded-2xl font-black shadow-xl hover:scale-105 transition-all flex items-center gap-3">
                        <span class="text-2xl">💬</span> Hubungi via WhatsApp
                    </a>
                    <a href="/verification" class="bg-black/20 backdrop-blur-md text-white border border-white/20 px-10 py-5 rounded-2xl font-black hover:bg-black/30 transition-all">
                        Cek Sertifikat
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection