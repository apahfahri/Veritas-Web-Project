@extends('layouts.admin')
@section('title', 'Laporan & Monitoring')
@section('page-title', 'Laporan & Monitoring')
@section('page-subtitle', 'Analitik bisnis, performa program, dan visualisasi data Veritas')

@section('content')

<!-- PRINT STYLESHEET (High Fidelity Print Engine) -->
<style>
    @media print {
        body {
            background: white !important;
            color: black !important;
            font-size: 12px !important;
        }
        /* Sembunyikan elemen non-cetak */
        aside, header, footer, .no-print, .filter-box, .btn-actions, nav, #header-actions, .header-container {
            display: none !important;
        }
        /* Hapus margin dashboard */
        .ml-72, .p-8, .p-6, .px-8, .py-6 {
            margin: 0 !important;
            padding: 0 !important;
        }
        /* Atur container cetak */
        .print-container {
            width: 100% !important;
            display: block !important;
        }
        .print-header {
            display: block !important;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 24px;
        }
        .bg-white {
            border: none !important;
            box-shadow: none !important;
        }
        .rounded-\[32px\], .rounded-\[2rem\] {
            border-radius: 0 !important;
        }
        /* Tabel Cetak */
        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }
        th, td {
            border: 1px solid #ddd !important;
            padding: 8px !important;
            font-size: 10px !important;
        }
        tr {
            page-break-inside: avoid !important;
        }
        /* Sembunyikan tombol aksi */
        .actions-col {
            display: none !important;
        }
    }
</style>

<!-- KOP SURAT / HEADER CETAK (Hanya Muncul saat Print/PDF) -->
<div class="hidden print-header">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">PT KATIGA VERITAS INDONESIA</h1>
            <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-0.5">Laporan Resmi Analitik & Monitoring Sistem</p>
        </div>
        <div class="text-right text-[9px] font-black text-slate-400 uppercase">
            Tanggal Cetak: {{ now()->format('d F Y H:i') }}<br>
            Akses: Superadmin Dashboard
        </div>
    </div>
</div>

<!-- GLOBAL FILTER BAR -->
<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 p-8 mb-8 no-print filter-box">
    <form method="GET" action="{{ route('admin.laporan.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-end" id="laporanFilterForm">
        
        <!-- Dropdown Jenis Laporan -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Jenis Laporan</label>
            <select name="type" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-100 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
                <option value="finance" {{ $type === 'finance' ? 'selected' : '' }}>Laporan Keuangan & Pendapatan</option>
                <option value="participants" {{ $type === 'participants' ? 'selected' : '' }}>Laporan Detail Peserta</option>
                <option value="products" {{ $type === 'products' ? 'selected' : '' }}>Laporan Evaluasi Produk</option>
            </select>
        </div>

        <!-- Date Picker: Dari Tanggal -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Mulai Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}"
                   class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
        </div>

        <!-- Date Picker: Sampai Tanggal -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}"
                   class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
        </div>

        <!-- Action Buttons -->
        <div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-slate-900 text-white py-3.5 rounded-2xl text-sm font-black hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 8.293A1 1 0 013 7.586V4z"></path></svg>
                    Saring
                </button>
                
                @if(request()->anyFilled(['start_date', 'end_date']))
                    <a href="{{ route('admin.laporan.index', ['type' => $type]) }}" class="px-5 bg-slate-100 text-slate-500 hover:bg-slate-200 transition rounded-2xl flex items-center justify-center" title="Reset Rentang Tanggal">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H18.2"></path></svg>
                    </a>
                @endif

                <!-- Excel Export -->
                <button type="button" onclick="exportTableToExcel('laporan-datatable')" class="px-5 bg-emerald-50 text-emerald-600 border border-emerald-100 hover:bg-emerald-100/60 rounded-2xl flex items-center justify-center transition" title="Export Excel (.csv)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </button>

                <!-- PDF/Print Export -->
                <button type="button" onclick="window.print()" class="px-5 bg-indigo-50 text-indigo-600 border border-indigo-100 hover:bg-indigo-100/60 rounded-2xl flex items-center justify-center transition" title="Cetak / Ekspor PDF">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                </button>
            </div>
        </div>

    </form>
</div>

<!-- ==============================================================
     SECTION A: LAPORAN KEUANGAN & PENDAPATAN
     ============================================================== -->
@if($type === 'finance')
<div class="space-y-8 print-container">
    
    <!-- STATS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Widget 1: Total Omset -->
        <div class="bg-white p-6 lg:p-8 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shadow-sm shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Total Omset Masuk</p>
                <h3 class="text-2xl lg:text-3xl font-black text-emerald-600 tracking-tight mt-0.5">Rp. {{ number_format($data['total_omset'], 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Widget 2: Total Piutang -->
        <div class="bg-white p-6 lg:p-8 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition">
            <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center shadow-sm shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Total Piutang Berjalan</p>
                <h3 class="text-2xl lg:text-3xl font-black text-amber-600 tracking-tight mt-0.5">Rp. {{ number_format($data['total_piutang'], 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- monthly bar chart -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 no-print">
        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6">Tren Omset Bulanan (Tahun ini)</h3>
        <div id="financeChart" class="w-full min-h-[350px]"></div>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Rekapitulasi Keuangan</h3>
            <span class="text-[10px] font-black text-slate-400 bg-slate-50 border px-3 py-1 rounded-full">{{ $registrations->count() }} Data Transaksi</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="laporan-datatable">
                <thead>
                    <tr class="bg-slate-100/50 border-b-2 border-slate-100">
                        <th class="p-6 text-[12px] font-black text-slate-900">No.</th>
                        <th class="p-6 text-[12px] font-black text-slate-900">No. Invoice</th>
                        <th class="p-6 text-[12px] font-black text-slate-900">Tanggal Daftar</th>
                        <th class="p-6 text-[12px] font-black text-slate-900">Nama Instansi / Klien</th>
                        <th class="p-6 text-[12px] font-black text-slate-900">Nominal Pendapatan</th>
                        <th class="p-6 text-[12px] font-black text-slate-900 text-center">Status Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($registrations as $index => $r)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-6 text-[12px] font-bold text-slate-400">{{ $index + 1 }}</td>
                        <td class="p-6 text-[12px] font-mono font-black text-indigo-600">{{ $r->no_registrasi }}</td>
                        <td class="p-6 text-[12px] text-slate-600">{{ $r->created_at ? $r->created_at->format('d M Y') : '—' }}</td>
                        <td class="p-6">
                            @if($r->is_utusan_perusahaan)
                                <div class="flex flex-col">
                                    <span class="text-[12px] font-black text-slate-900">{{ $r->perusahaan?->nama }}</span>
                                    <span class="text-[9px] font-extrabold text-indigo-500 uppercase tracking-widest mt-0.5">Perusahaan ({{ $r->user?->nama }})</span>
                                </div>
                            @else
                                <div class="flex flex-col">
                                    <span class="text-[12px] font-black text-slate-900">{{ $r->user?->nama }}</span>
                                    <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mt-0.5">Individu / Mandiri</span>
                                </div>
                            @endif
                        </td>
                        <td class="p-6 text-[12px] font-black text-slate-900">Rp. {{ number_format($r->jadwal?->harga ?? 0, 0, ',', '.') }}</td>
                        <td class="p-6 text-center">
                            @if($r->status_bayar === 'lunas')
                                <span class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">Lunas</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100">Belum Lunas</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="p-16 text-center text-[12px] font-bold text-slate-400">Tidak ada data transaksi ditemukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- PAGINATION -->
        @if($registrations->hasPages())
        <div class="px-8 py-5 border-t border-slate-100 bg-slate-50/30 flex flex-col sm:flex-row items-center justify-between gap-4 no-print">
            <p class="text-[12px] font-medium text-slate-500">
                Menampilkan
                <span class="font-black text-slate-800">{{ $registrations->firstItem() }}–{{ $registrations->lastItem() }}</span>
                dari
                <span class="font-black text-slate-800">{{ $registrations->total() }}</span>
                data transaksi
            </p>
            <div class="flex items-center gap-1">
                {{-- Previous --}}
                @if($registrations->onFirstPage())
                    <span class="px-3 py-1.5 text-[11px] font-black text-slate-300 border border-slate-100 rounded-xl cursor-not-allowed bg-white">‹</span>
                @else
                    <a href="{{ $registrations->previousPageUrl() }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">‹</a>
                @endif

                {{-- Pages --}}
                @for($i = 1; $i <= $registrations->lastPage(); $i++)
                    @if($i == $registrations->currentPage())
                        <span class="px-3 py-1.5 text-[11px] font-black text-white bg-slate-900 rounded-xl">{{ $i }}</span>
                    @else
                        <a href="{{ $registrations->url($i) }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">{{ $i }}</a>
                    @endif
                @endfor

                {{-- Next --}}
                @if($registrations->hasMorePages())
                    <a href="{{ $registrations->nextPageUrl() }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">›</a>
                @else
                    <span class="px-3 py-1.5 text-[11px] font-black text-slate-300 border border-slate-100 rounded-xl cursor-not-allowed bg-white">›</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endif

<!-- ==============================================================
     SECTION B: LAPORAN DETAIL PESERTA
     ============================================================== -->
@if($type === 'participants')
<div class="space-y-8 print-container">
    
    <!-- pie/donut chart -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 no-print flex flex-col items-center">
        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6 self-start">Rasio Pendaftar (Perusahaan vs Individu)</h3>
        <div id="participantsChart" class="w-full max-w-[450px]"></div>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Rekapitulasi Detail Peserta</h3>
            <span class="text-[10px] font-black text-slate-400 bg-slate-50 border px-3 py-1 rounded-full">{{ $registrations->count() }} Pendaftar</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="laporan-datatable">
                <thead>
                    <tr class="bg-slate-100/50 border-b-2 border-slate-100">
                        <th class="p-6 text-[12px] font-black text-slate-900">No.</th>
                        <th class="p-6 text-[12px] font-black text-slate-900">Tanggal Daftar</th>
                        <th class="p-6 text-[12px] font-black text-slate-900">Nama Lengkap</th>
                        <th class="p-6 text-[12px] font-black text-slate-900">Kategori / Asal Perusahaan</th>
                        <th class="p-6 text-[12px] font-black text-slate-900">Layanan K3 yang Diambil</th>
                        <th class="p-6 text-[12px] font-black text-slate-900 text-center">Status Progres</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($registrations as $index => $r)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-6 text-[12px] font-bold text-slate-400">{{ $index + 1 }}</td>
                        <td class="p-6 text-[12px] text-slate-600">{{ $r->created_at ? $r->created_at->format('d M Y') : '—' }}</td>
                        <td class="p-6">
                            <div class="flex flex-col">
                                <span class="text-[12px] font-black text-slate-900">{{ $r->user?->nama }}</span>
                                <span class="text-[10px] text-slate-400 font-bold">{{ $r->user?->email }}</span>
                            </div>
                        </td>
                        <td class="p-6">
                            @if($r->is_utusan_perusahaan)
                                <div class="flex flex-col">
                                    <span class="text-[12px] font-black text-slate-900">{{ $r->perusahaan?->nama }}</span>
                                    <span class="text-[9px] font-extrabold text-indigo-500 uppercase tracking-widest mt-0.5">Utusan Perusahaan</span>
                                </div>
                            @else
                                <span class="inline-flex px-2.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-slate-100 text-slate-500 border border-slate-200">Individu / Mandiri</span>
                            @endif
                        </td>
                        <td class="p-6 text-[12px] font-bold text-slate-700 leading-relaxed">{{ $r->jadwal?->jenis?->nama ?? ($r->jadwal?->kategori?->nama ?? '—') }}</td>
                        <td class="p-6 text-center">
                            @php 
                                $c = match($r->status_progres) { 
                                    'selesal', 'selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-100', 
                                    'diproses' => 'bg-blue-50 text-blue-600 border-blue-100', 
                                    'dibatalkan' => 'bg-red-50 text-red-600 border-red-100', 
                                    default => 'bg-amber-50 text-amber-600 border-amber-100' 
                                }; 
                            @endphp
                            <span class="inline-flex px-2.5 py-0.5 rounded text-[9px] font-black uppercase tracking-widest border {{ $c }}">
                                {{ str_replace('_', ' ', $r->status_progres) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="p-16 text-center text-[12px] font-bold text-slate-400">Tidak ada pendaftar ditemukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- PAGINATION -->
        @if($registrations->hasPages())
        <div class="px-8 py-5 border-t border-slate-100 bg-slate-50/30 flex flex-col sm:flex-row items-center justify-between gap-4 no-print">
            <p class="text-[12px] font-medium text-slate-500">
                Menampilkan
                <span class="font-black text-slate-800">{{ $registrations->firstItem() }}–{{ $registrations->lastItem() }}</span>
                dari
                <span class="font-black text-slate-800">{{ $registrations->total() }}</span>
                pendaftar
            </p>
            <div class="flex items-center gap-1">
                {{-- Previous --}}
                @if($registrations->onFirstPage())
                    <span class="px-3 py-1.5 text-[11px] font-black text-slate-300 border border-slate-100 rounded-xl cursor-not-allowed bg-white">‹</span>
                @else
                    <a href="{{ $registrations->previousPageUrl() }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">‹</a>
                @endif

                {{-- Pages --}}
                @for($i = 1; $i <= $registrations->lastPage(); $i++)
                    @if($i == $registrations->currentPage())
                        <span class="px-3 py-1.5 text-[11px] font-black text-white bg-slate-900 rounded-xl">{{ $i }}</span>
                    @else
                        <a href="{{ $registrations->url($i) }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">{{ $i }}</a>
                    @endif
                @endfor

                {{-- Next --}}
                @if($registrations->hasMorePages())
                    <a href="{{ $registrations->nextPageUrl() }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">›</a>
                @else
                    <span class="px-3 py-1.5 text-[11px] font-black text-slate-300 border border-slate-100 rounded-xl cursor-not-allowed bg-white">›</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endif

<!-- ==============================================================
     SECTION C: LAPORAN EVALUASI PRODUK
     ============================================================== -->
@if($type === 'products')
<div class="space-y-8 print-container">
    
    <!-- horizontal bar chart -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 no-print">
        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6">Top 5 Layanan Terlaris</h3>
        <div id="productsChart" class="w-full min-h-[350px]"></div>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Tingkat Penjualan & Kontribusi Produk</h3>
            <span class="text-[10px] font-black text-slate-400 bg-slate-50 border px-3 py-1 rounded-full">{{ $data['products']->count() }} Layanan Terdaftar</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="laporan-datatable">
                <thead>
                    <tr class="bg-slate-100/50 border-b-2 border-slate-100">
                        <th class="p-6 text-[12px] font-black text-slate-900">No.</th>
                        <th class="p-6 text-[12px] font-black text-slate-900">Nama Layanan K3</th>
                        <th class="p-6 text-[12px] font-black text-slate-900">Kategori Layanan</th>
                        <th class="p-6 text-[12px] font-black text-slate-900 text-center">Jumlah Penjualan (Qty)</th>
                        <th class="p-6 text-[12px] font-black text-slate-900">Kontribusi ke Omset</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($data['products'] as $index => $p)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-6 text-[12px] font-bold text-slate-400">{{ $index + 1 }}</td>
                        <td class="p-6 text-[12px] font-black text-slate-900">{{ $p->nama_layanan }}</td>
                        <td class="p-6 text-[12px] font-bold text-slate-500">{{ $p->nama_kategori }}</td>
                        <td class="p-6 text-center text-[12px] font-black text-indigo-600">{{ number_format($p->qty) }} Pendaftar</td>
                        <td class="p-6 text-[12px] font-black text-slate-950">Rp. {{ number_format($p->revenue ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-16 text-center text-[12px] font-bold text-slate-400">Tidak ada data evaluasi produk ditemukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- PAGINATION -->
        @if($data['products']->hasPages())
        <div class="px-8 py-5 border-t border-slate-100 bg-slate-50/30 flex flex-col sm:flex-row items-center justify-between gap-4 no-print">
            <p class="text-[12px] font-medium text-slate-500">
                Menampilkan
                <span class="font-black text-slate-800">{{ $data['products']->firstItem() }}–{{ $data['products']->lastItem() }}</span>
                dari
                <span class="font-black text-slate-800">{{ $data['products']->total() }}</span>
                layanan terdaftar
            </p>
            <div class="flex items-center gap-1">
                {{-- Previous --}}
                @if($data['products']->onFirstPage())
                    <span class="px-3 py-1.5 text-[11px] font-black text-slate-300 border border-slate-100 rounded-xl cursor-not-allowed bg-white">‹</span>
                @else
                    <a href="{{ $data['products']->previousPageUrl() }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">‹</a>
                @endif

                {{-- Pages --}}
                @for($i = 1; $i <= $data['products']->lastPage(); $i++)
                    @if($i == $data['products']->currentPage())
                        <span class="px-3 py-1.5 text-[11px] font-black text-white bg-slate-900 rounded-xl">{{ $i }}</span>
                    @else
                        <a href="{{ $data['products']->url($i) }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">{{ $i }}</a>
                    @endif
                @endfor

                {{-- Next --}}
                @if($data['products']->hasMorePages())
                    <a href="{{ $data['products']->nextPageUrl() }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">›</a>
                @else
                    <span class="px-3 py-1.5 text-[11px] font-black text-slate-300 border border-slate-100 rounded-xl cursor-not-allowed bg-white">›</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const type = "{{ $type }}";

        if (type === 'finance') {
            // A. Monthly omset bar chart
            const labels = {!! json_encode($data['chart_labels'] ?? []) !!};
            const seriesData = {!! json_encode($data['chart_series'] ?? []) !!};

            const options = {
                series: [{
                    name: 'Total Pendapatan',
                    data: seriesData
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    width: '100%',
                    redrawOnParentResize: true,
                    redrawOnWindowResize: true,
                    toolbar: { show: false },
                    fontFamily: 'Outfit, sans-serif'
                },
                colors: ['#10b981'],
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '50%',
                        dataLabels: { position: 'top' }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        if (val >= 1000000) return (val / 1000000).toFixed(1) + 'M';
                        if (val >= 1000) return (val / 1000).toFixed(0) + 'K';
                        return val;
                    },
                    offsetY: -20,
                    style: { fontSize: '10px', fontWeight: 900, colors: ["#334155"] }
                },
                xaxis: {
                    categories: labels,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { style: { colors: '#94a3b8', fontWeight: 800, fontSize: '10px' } }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#94a3b8', fontWeight: 800, fontSize: '10px' },
                        formatter: function (val) {
                            return 'Rp ' + (val / 1000000).toFixed(0) + 'jt';
                        }
                    }
                },
                grid: { borderColor: '#f8fafc', strokeDashArray: 5 }
            };

            const chart = new ApexCharts(document.querySelector("#financeChart"), options);
            chart.render();

        } else if (type === 'participants') {
            // B. Rasio B2B vs B2C donut chart
            const b2b = parseInt("{{ $data['b2b_count'] ?? 0 }}");
            const b2c = parseInt("{{ $data['b2c_count'] ?? 0 }}");

            const options = {
                series: [b2b, b2c],
                labels: ['Klien Perusahaan', 'Klien Individu'],
                chart: {
                    type: 'donut',
                    height: 350,
                    width: '100%',
                    redrawOnParentResize: true,
                    redrawOnWindowResize: true,
                    fontFamily: 'Outfit, sans-serif'
                },
                colors: ['#6366f1', '#94a3b8'],
                legend: {
                    position: 'bottom',
                    fontSize: '11px',
                    fontWeight: 900,
                    itemMargin: { horizontal: 15 }
                },
                dataLabels: { enabled: true },
                responsive: [{
                    breakpoint: 480,
                    options: { chart: { width: 200 } }
                }]
            };

            const chart = new ApexCharts(document.querySelector("#participantsChart"), options);
            chart.render();

        } else if (type === 'products') {
            // C. Top 5 popular products horizontal bar chart
            const labels = {!! json_encode($data['chart_labels'] ?? []) !!};
            const seriesData = {!! json_encode($data['chart_series'] ?? []) !!};

            const options = {
                series: [{
                    name: 'Jumlah Terjual',
                    data: seriesData
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    width: '100%',
                    redrawOnParentResize: true,
                    redrawOnWindowResize: true,
                    toolbar: { show: false },
                    fontFamily: 'Outfit, sans-serif'
                },
                colors: ['#6366f1'],
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 6,
                        barHeight: '45%'
                    }
                },
                dataLabels: { enabled: true, style: { fontSize: '10px', fontWeight: 900 } },
                xaxis: {
                    categories: labels,
                    axisBorder: { show: false },
                    labels: { style: { colors: '#94a3b8', fontWeight: 800, fontSize: '10px' } }
                },
                yaxis: {
                    labels: { style: { colors: '#334155', fontWeight: 800, fontSize: '10px' } }
                },
                grid: { borderColor: '#f8fafc', strokeDashArray: 5 }
            };

            const chart = new ApexCharts(document.querySelector("#productsChart"), options);
            chart.render();
        }

        // Force chart to recalculate and expand to 100% width on page load / refresh
        setTimeout(function() {
            window.dispatchEvent(new Event('resize'));
        }, 150);
    });

    /**
     * Client-Side Excel / CSV Exporter Engine
     * Mengonversi isi tabel dinamis aktif menjadi format berkas CSV siap pakai.
     */
    function exportTableToExcel(tableID, filename = '') {
        const table = document.getElementById(tableID);
        if (!table) return;

        let csv = [];
        const rows = table.querySelectorAll("tr");

        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll("td, th");

            for (let j = 0; j < cols.length; j++) {
                // Bersihkan teks, hilangkan baris baru dan koma untuk format CSV
                let cleanVal = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").trim();
                cleanVal = cleanVal.replace(/"/g, '""'); // Escape double quotes
                row.push('"' + cleanVal + '"');
            }
            csv.push(row.join(","));
        }

        const csvContent = "data:text/csv;charset=utf-8,\uFEFF" + csv.join("\n");
        const encodedUri = encodeURI(csvContent);
        
        const typeStr = "{{ $type }}";
        const dateStr = new Date().toISOString().slice(0, 10);
        filename = `Laporan-${typeStr}-${dateStr}.csv`;

        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", filename);
        document.body.appendChild(link);
        
        link.click();
        document.body.removeChild(link);
    }
</script>
@endpush
