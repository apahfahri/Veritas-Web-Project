@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA] flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#7d2ae7] text-white min-h-screen p-6">

        <h2 class="text-xl font-bold mb-8">Admin Panel</h2>

        <nav class="space-y-2">

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-[#7d2ae7]">
                📊 Dashboard
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10">
                🎓 Pelatihan
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10">
                💬 Konsultasi
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10">
                📋 Audit
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10">
                👥 Peserta
            </a>

            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10">
                🏆 Sertifikat
            </a>

        </nav>

        <div class="mt-10 border-t border-white/10 pt-4">
            <a href="/" class="block text-sm hover:underline">Keluar</a>
        </div>

    </aside>


    <!-- MAIN -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <header class="bg-white px-8 py-4 border-b flex justify-between items-center">
            <h1 class="text-2xl font-bold text-[#7d2ae7]">
                Dashboard Overview
            </h1>

            <div class="text-right">
                <div class="text-sm font-medium">Admin</div>
                <div class="text-xs text-gray-500">admin@katigaveritas.com</div>
            </div>
        </header>


        <!-- CONTENT -->
        <main class="p-8 space-y-6">

            <!-- KPI -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">

                <div class="bg-white p-6 rounded-xl shadow">
                    <div class="text-sm text-gray-500">Total Peserta</div>
                    <div class="text-2xl font-bold mt-2">1200</div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <div class="text-sm text-gray-500">Pelatihan Aktif</div>
                    <div class="text-2xl font-bold mt-2 text-[#7d2ae7]">24</div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <div class="text-sm text-gray-500">Audit Selesai</div>
                    <div class="text-2xl font-bold mt-2 text-[#7d2ae7]">50</div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <div class="text-sm text-gray-500">Sertifikat</div>
                    <div class="text-2xl font-bold mt-2 text-green-600">800</div>
                </div>

            </div>


            <!-- TABLE -->
            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="font-bold mb-4">Pendaftaran Terbaru</h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">

                        <thead>
                            <tr class="text-left border-b">
                                <th class="py-2">ID</th>
                                <th>Pelatihan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">

                            <tr>
                                <td class="py-2">TRX001</td>
                                <td>K3 Umum</td>
                                <td><span class="bg-green-500 text-white px-2 py-1 rounded text-xs">Approved</span></td>
                                <td>01 Jan 2026</td>
                                <td>👁️</td>
                            </tr>

                            <tr>
                                <td class="py-2">TRX002</td>
                                <td>K3 Listrik</td>
                                <td><span class="bg-yellow-500 text-white px-2 py-1 rounded text-xs">Pending</span></td>
                                <td>02 Jan 2026</td>
                                <td>👁️</td>
                            </tr>

                        </tbody>

                    </table>
                </div>

            </div>

        </main>

    </div>

</div>

@endsection