@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-[#0A2540] to-[#00A8A8] text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-4xl font-bold mb-4">Pelatihan K3</h1>
            <p class="text-lg text-gray-200">
                Pilih program pelatihan K3 yang sesuai dengan kebutuhan Anda
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- SEARCH + FILTER -->
        <div class="bg-white p-6 rounded-xl shadow mb-8">

            <div class="grid md:grid-cols-5 gap-4">

                <!-- SEARCH -->
                <div class="md:col-span-2 relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
                    <input type="text"
                           placeholder="Cari pelatihan..."
                           class="w-full border rounded pl-10 py-2">
                </div>

                <!-- CATEGORY -->
                <select class="border rounded px-3 py-2">
                    <option>Semua Kategori</option>
                    <option>K3 Umum</option>
                    <option>K3 Listrik</option>
                </select>

                <!-- MODE -->
                <select class="border rounded px-3 py-2">
                    <option>Semua Mode</option>
                    <option>Online</option>
                    <option>Offline</option>
                    <option>Hybrid</option>
                </select>

                <!-- PRICE -->
                <select class="border rounded px-3 py-2">
                    <option>Semua Harga</option>
                    <option>&lt; Rp 3jt</option>
                    <option>Rp 3jt - 5jt</option>
                    <option>&gt; Rp 5jt</option>
                </select>

            </div>

        </div>

        <!-- RESULT -->
        <div class="mb-6 text-gray-600">
            Menampilkan 6 dari 6 pelatihan
        </div>


        <!-- GRID -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- CARD -->
            <div class="bg-white rounded-xl shadow overflow-hidden group hover:shadow-xl transition">

                <!-- IMAGE -->
                <div class="aspect-video overflow-hidden bg-gray-200">
                    <img src="https://images.unsplash.com/photo-1601021545082-4385509b3074"
                         class="w-full h-full object-cover group-hover:scale-105 transition">
                </div>

                <div class="p-6">

                    <!-- BADGE -->
                    <div class="flex justify-between mb-3">
                        <span class="bg-[#0A2540] text-white text-xs px-2 py-1 rounded">
                            K3 Umum
                        </span>

                        <span class="border text-xs px-2 py-1 rounded">
                            Online
                        </span>
                    </div>

                    <!-- TITLE -->
                    <h3 class="text-xl font-semibold text-[#0A2540] mb-2">
                        Pelatihan K3 Umum Sertifikasi
                    </h3>

                    <!-- DESC -->
                    <p class="text-sm text-gray-600 mb-4">
                        Pelatihan lengkap K3 untuk profesional industri
                    </p>

                    <!-- INFO -->
                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                        <div class="flex justify-between">
                            <span>Durasi:</span>
                            <span class="font-medium">3 Hari</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Instruktur:</span>
                            <span class="font-medium">Ahmad</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Batch:</span>
                            <span class="font-medium">2</span>
                        </div>
                    </div>

                    <!-- PRICE -->
                    <div class="border-t pt-4 flex justify-between items-center">
                        <div>
                            <div class="text-sm text-gray-500">Mulai dari</div>
                            <div class="text-2xl font-bold text-[#0A2540]">
                                Rp 2jt
                            </div>
                        </div>

                        <a href="{{ route('training.detail', ['id' => 1]) }}"
   class="bg-[#00A8A8] text-white px-4 py-2 rounded">
    Daftar
</a>
                    </div>

                </div>
            </div>



@foreach (range(1,5) as $i)
    <div class="bg-white rounded-xl shadow overflow-hidden"></div>
@endforeach

        </div>

    </div>

</div>

@endsection