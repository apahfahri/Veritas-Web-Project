@extends('layouts.app')

@section('content')

<!-- HERO -->
<section class="relative bg-gradient-to-br from-[#0A2540] via-[#0d3456] to-[#00A8A8] text-white overflow-hidden">
    <div class="absolute inset-0 bg-[size:20px_20px] opacity-10"></div>

    <div class="relative max-w-7xl mx-auto px-6 py-20 lg:py-32 grid lg:grid-cols-2 gap-12 items-center">

        <div class="space-y-6">

            <span class="bg-[#FF7A00] px-4 py-1 rounded-full text-sm">
                Terpercaya & Bersertifikat
            </span>

            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold">
                Solusi Pelatihan & Konsultasi K3 Profesional
            </h1>

            <p class="text-lg text-gray-200">
                Tingkatkan standar keselamatan kerja perusahaan Anda dengan pelatihan K3 berkualitas.
            </p>

            <div class="flex gap-4 pt-4">
                <a href="/training" class="bg-[#FF7A00] px-6 py-3 rounded">
                    🎓 Lihat Pelatihan
                </a>

                <a href="/consultation" class="border px-6 py-3 rounded">
                    💬 Konsultasi
                </a>
            </div>

            <div class="flex gap-8 pt-8">
                <div>
                    <div class="text-3xl font-bold">1000+</div>
                    <div class="text-gray-300">Peserta</div>
                </div>
                <div>
                    <div class="text-3xl font-bold">50+</div>
                    <div class="text-gray-300">Perusahaan</div>
                </div>
                <div>
                    <div class="text-3xl font-bold">15+</div>
                    <div class="text-gray-300">Tahun</div>
                </div>
            </div>

        </div>

        <div class="hidden lg:block">
            <img src="https://images.unsplash.com/photo-1738782582520-d1be2a9d7bca"
                 class="rounded-2xl shadow-2xl">
        </div>

    </div>
</section>


<!-- COMPANY -->
<section class="py-16 text-center">
    <h2 class="text-3xl font-bold text-[#0A2540]">
        PT Katiga Veritas Indonesia
    </h2>

    <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
        Perusahaan penyedia layanan pelatihan, konsultasi, dan audit K3 profesional.
    </p>
</section>


<!-- SERVICES -->
<section class="py-16 bg-[#F5F7FA]">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-8">

        <!-- CARD -->
        <div class="bg-white p-8 rounded-xl shadow hover:shadow-xl transition">
            <div class="text-4xl mb-4">🎓</div>
            <h3 class="text-xl font-bold mb-2">Pelatihan K3</h3>
            <p class="text-gray-600 text-sm">
                Sertifikasi resmi dan pelatihan profesional.
            </p>
        </div>

        <div class="bg-white p-8 rounded-xl shadow hover:shadow-xl transition">
            <div class="text-4xl mb-4">👥</div>
            <h3 class="text-xl font-bold mb-2">Konsultasi</h3>
            <p class="text-gray-600 text-sm">
                Konsultan berpengalaman sesuai kebutuhan.
            </p>
        </div>

        <div class="bg-white p-8 rounded-xl shadow hover:shadow-xl transition">
            <div class="text-4xl mb-4">📋</div>
            <h3 class="text-xl font-bold mb-2">Audit K3</h3>
            <p class="text-gray-600 text-sm">
                Audit sistem K3 profesional.
            </p>
        </div>

    </div>
</section>


<!-- WHY -->
<section class="py-16 text-center">
    <h2 class="text-3xl font-bold text-[#0A2540] mb-10">
        Mengapa Memilih Kami?
    </h2>

    <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">

        <div>
            <div class="text-4xl mb-4">🛡️</div>
            <h3 class="font-bold">Amanah</h3>
            <p class="text-gray-600 text-sm">
                Integritas tinggi dan transparansi.
            </p>
        </div>

        <div>
            <div class="text-4xl mb-4">🏆</div>
            <h3 class="font-bold">Profesional</h3>
            <p class="text-gray-600 text-sm">
                Tim bersertifikat.
            </p>
        </div>

        <div>
            <div class="text-4xl mb-4">📈</div>
            <h3 class="font-bold">Syar'i</h3>
            <p class="text-gray-600 text-sm">
                Sesuai prinsip syariah.
            </p>
        </div>

    </div>
</section>


<!-- TESTIMONI -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-8">

        <div class="bg-gray-50 p-6 rounded-xl shadow">
            ⭐⭐⭐⭐⭐
            <p class="mt-4 text-gray-600 italic">
                "Pelatihan sangat membantu!"
            </p>
            <div class="mt-4 font-bold">Budi</div>
        </div>

        <div class="bg-gray-50 p-6 rounded-xl shadow">
            ⭐⭐⭐⭐⭐
            <p class="mt-4 text-gray-600 italic">
                "Profesional dan terpercaya"
            </p>
            <div class="mt-4 font-bold">Andi</div>
        </div>

        <div class="bg-gray-50 p-6 rounded-xl shadow">
            ⭐⭐⭐⭐⭐
            <p class="mt-4 text-gray-600 italic">
                "Highly recommended!"
            </p>
            <div class="mt-4 font-bold">Sari</div>
        </div>

    </div>
</section>


<!-- CTA -->
<section class="py-16 bg-gradient-to-r from-[#0A2540] to-[#00A8A8] text-white text-center">
    <h2 class="text-3xl font-bold">
        Siap Meningkatkan Standar K3?
    </h2>

    <div class="mt-6 flex justify-center gap-4">
        <a href="#" class="bg-[#FF7A00] px-6 py-3 rounded">
            WhatsApp
        </a>
        <a href="#" class="border px-6 py-3 rounded">
            Verifikasi
        </a>
    </div>
</section>

@endsection