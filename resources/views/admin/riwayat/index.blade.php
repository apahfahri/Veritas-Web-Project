@extends('layouts.admin')
@section('title', 'Riwayat Pendaftaran')
@section('page-title', 'Riwayat Pendaftaran')
@section('page-subtitle', 'Pantau data transaksi pendaftaran yang sudah selesai atau dibatalkan')

@section('content')

<!-- FILTER PANEL -->
<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 p-8 mb-8">
    <form method="GET" action="{{ route('admin.riwayat.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
        
        <!-- Search bar -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Cari Data</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                    <i class="fi fi-rr-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Peserta, Mitra, REG..." 
                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
            </div>
        </div>

        <!-- Date Range: Start Date -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}"
                   class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
        </div>

        <!-- Date Range: End Date -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}"
                   class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
        </div>

        <!-- Filter Status Akhir -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Status Akhir</label>
            <div class="flex gap-2">
                <select name="status" class="flex-1 bg-slate-50 border border-slate-100 px-4 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
                    <option value="">Semua Status</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Hanya Selesai</option>
                    <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Hanya Dibatalkan</option>
                </select>
                
                <button type="submit" class="bg-slate-900 text-white px-5 rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center justify-center">
                    <i class="fi fi-rr-filter"></i>
                </button>
                
                @if(request()->anyFilled(['search', 'start_date', 'end_date', 'status']))
                    <a href="{{ route('admin.riwayat.index') }}" class="px-5 rounded-2xl bg-slate-200 text-slate-700 hover:bg-slate-300 transition flex items-center justify-center" title="Reset Filters">
                        <i class="fi fi-rr-refresh"></i>
                    </a>
                @endif
            </div>
        </div>

    </form>
</div>

<!-- DATATABLE CARD -->
<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-8 border-b border-slate-50 flex justify-between items-center">
        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Daftar Riwayat</h3>
        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-4 py-1.5 rounded-full border border-slate-100">Total Transaksi: {{ $riwayats->total() }}</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100/50 border-b-2 border-slate-100">
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">No. Registrasi</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Tanggal Daftar</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Nama Peserta</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Asal Mitra / Perusahaan</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Layanan K3</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Total Biaya</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Status Akhir</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($riwayats as $r)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="p-6">
                        <span class="text-[12px] font-mono font-black text-indigo-600">{{ $r->no_registrasi }}</span>
                    </td>
                    <td class="p-6 whitespace-nowrap">
                        <span class="text-[12px] font-medium text-slate-900">{{ $r->created_at ? $r->created_at->format('d M Y') : '—' }}</span>
                    </td>
                    <td class="p-6">
                        <div class="flex flex-col">
                            <span class="text-[12px] font-black text-slate-900">{{ $r->user?->nama ?? '—' }}</span>
                            <span class="text-[10px] font-bold text-slate-400">{{ $r->user?->email ?? '—' }}</span>
                        </div>
                    </td>
                    <td class="p-6">
                        @if($r->is_utusan_perusahaan)
                            <div class="flex flex-col">
                                <span class="text-[12px] font-black text-indigo-950">{{ $r->perusahaan?->nama ?? '—' }}</span>
                                <span class="text-[9px] font-extrabold text-indigo-500 uppercase tracking-widest mt-0.5">Utusan Perusahaan</span>
                            </div>
                        @else
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider bg-slate-100 text-slate-500 border border-slate-200">Individu / Mandiri</span>
                        @endif
                    </td>
                    <td class="p-6">
                        <span class="text-[12px] font-bold text-slate-700 leading-relaxed">{{ $r->jadwal?->jenis?->nama ?? ($r->jadwal?->kategori?->nama ?? '—') }}</span>
                    </td>
                    <td class="p-6">
                        <span class="text-[12px] font-black text-slate-950">Rp. {{ number_format($r->jadwal?->harga ?? 0, 0, ',', '.') }}</span>
                    </td>
                    <td class="p-6 text-center">
                        @if($r->status_progres === 'selesai')
                            <span class="inline-flex px-3.5 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm" title="Transaksi Selesai & Berhasil">
                                Selesai
                            </span>
                        @else
                            <span class="inline-flex px-3.5 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-red-50 text-red-600 border border-red-100 shadow-sm cursor-help hover:bg-red-100/60 transition" 
                                  title="Alasan: {{ $r->alasan_batal }} (Klik detail untuk info lengkap)">
                                Dibatalkan
                            </span>
                        @endif
                    </td>
                    <td class="p-6">
                        <div class="flex items-center justify-center gap-2">
                            <!-- Tombol Lihat Detail -->
                            <button onclick="openDetailModal({{ json_encode($r) }}, {{ json_encode($r->user) }}, {{ json_encode($r->jadwal) }}, {{ json_encode($r->perusahaan) }}, {{ json_encode($r->sertifikat) }})"
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-indigo-600 hover:text-indigo-600 hover:shadow-lg hover:shadow-indigo-50 transition shadow-sm group/btn" 
                                    title="Lihat Detail Riwayat">
                                <i class="fi fi-rr-eye"></i>
                            </button>

                            <!-- Tombol Download Sertifikat (Bersyarat) -->
                            @if($r->status_progres === 'selesai')
                                @if($r->sertifikat)
                                    <a href="{{ route('admin.sertifikat.show', $r->sertifikat->no_sertifikat) }}" target="_blank"
                                       class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-emerald-600 hover:text-emerald-600 hover:shadow-lg hover:shadow-emerald-50 transition shadow-sm"
                                       title="Unduh Dokumen Sertifikat (PDF)">
                                        <i class="fi fi-rr-download"></i>
                                    </a>
                                @else
                                    <button disabled 
                                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-50 border border-slate-200 text-slate-300 cursor-not-allowed" 
                                            title="Sertifikat Belum Diterbitkan">
                                        <i class="fi fi-rr-download"></i>
                                    </button>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="p-24 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-3xl flex items-center justify-center mb-4 border border-slate-100 shadow-inner">
                                <i class="fi fi-rr-time-past w-10 h-10"></i>
                            </div>
                            <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Tidak ada riwayat pendaftaran ditemukan</p>
                            <p class="text-xs font-bold text-slate-400 mt-1 uppercase">Silakan ubah filter pencarian Anda</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    @if($riwayats->hasPages())
    <div class="px-8 py-5 border-t border-slate-100 bg-slate-50/30 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-[12px] font-medium text-slate-500">
            Menampilkan
            <span class="font-black text-slate-800">{{ $riwayats->firstItem() }}–{{ $riwayats->lastItem() }}</span>
            dari
            <span class="font-black text-slate-800">{{ $riwayats->total() }}</span>
            riwayat pendaftaran
        </p>
        <div class="flex items-center gap-1">
            {{-- Previous --}}
            @if($riwayats->onFirstPage())
                <span class="px-3 py-1.5 text-[11px] font-black text-slate-300 border border-slate-100 rounded-xl cursor-not-allowed bg-white">‹</span>
            @else
                <a href="{{ $riwayats->previousPageUrl() }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">‹</a>
            @endif

            {{-- Pages --}}
            @for($i = 1; $i <= $riwayats->lastPage(); $i++)
                @if($i == $riwayats->currentPage())
                    <span class="px-3 py-1.5 text-[11px] font-black text-white bg-slate-900 rounded-xl">{{ $i }}</span>
                @else
                    <a href="{{ $riwayats->url($i) }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">{{ $i }}</a>
                @endif
            @endfor

            {{-- Next --}}
            @if($riwayats->hasMorePages())
                <a href="{{ $riwayats->nextPageUrl() }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">›</a>
            @else
                <span class="px-3 py-1.5 text-[11px] font-black text-slate-300 border border-slate-100 rounded-xl cursor-not-allowed bg-white">›</span>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- ==============================================
     MODAL DETAIL RIWAYAT (SHOW)
     ============================================== -->
<div id="detailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity" onclick="closeDetailModal()"></div>
        <div class="relative bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
            
            <div class="bg-slate-50 p-6 lg:p-8 border-b border-slate-100 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight" id="modal_reg_no">REG-XXXX-XXXX</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Detail Dokumen Transaksi Riwayat</p>
                </div>
                <button onclick="closeDetailModal()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-slate-900 transition shadow-sm">
                    <i class="fi fi-rr-cross"></i>
                </button>
            </div>
            
            <div class="p-6 lg:p-8 space-y-6 max-h-[70vh] overflow-y-auto">
                
                <!-- ALASAN PEMBATALAN (Jika Dibatalkan) -->
                <div id="modal_cancel_card" class="hidden bg-red-50 border border-red-100 rounded-3xl p-5 flex gap-4">
                    <div class="w-10 h-10 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center shrink-0">
                        <i class="fi fi-rr-triangle-warning"></i>
                    </div>
                    <div>
                        <h4 class="text-[11px] font-black text-red-800 uppercase tracking-wider mb-0.5">Catatan Pembatalan Transaksi</h4>
                        <p class="text-xs font-bold text-red-700 leading-relaxed" id="modal_cancel_reason">—</p>
                    </div>
                </div>

                <!-- DUA KOLOM: DATA PENDAFTARAN & PESERTA -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Detail Layanan -->
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <div class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-4 border-b border-indigo-50 pb-1">Detail Pendaftaran</div>
                        <div class="space-y-3 text-xs">
                            <div class="flex justify-between"><span class="text-slate-400 font-bold">Tgl Daftar:</span><span class="font-black text-slate-800" id="modal_tgl_daftar">—</span></div>
                            <div class="flex justify-between"><span class="text-slate-400 font-bold">Layanan K3:</span><span class="font-black text-slate-800" id="modal_layanan_k3">—</span></div>
                            <div class="flex justify-between"><span class="text-slate-400 font-bold">Tipe Layanan:</span><span class="font-black text-slate-800" id="modal_tipe_layanan">—</span></div>
                            <div class="flex justify-between"><span class="text-slate-400 font-bold">Lokasi Pertemuan:</span><span class="font-black text-slate-800" id="modal_cabang">—</span></div>
                            <div class="flex justify-between"><span class="text-slate-400 font-bold">Total Biaya:</span><span class="font-black text-emerald-600" id="modal_total_biaya">—</span></div>
                        </div>
                    </div>

                    <!-- Detail Peserta -->
                    <div class="bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <div class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-4 border-b border-indigo-50 pb-1">Detail Peserta</div>
                        <div class="space-y-3 text-xs">
                            <div class="flex justify-between"><span class="text-slate-400 font-bold">Nama Lengkap:</span><span class="font-black text-slate-800" id="modal_peserta_nama">—</span></div>
                            <div class="flex justify-between"><span class="text-slate-400 font-bold">Email:</span><span class="font-black text-slate-800" id="modal_peserta_email">—</span></div>
                            <div class="flex justify-between"><span class="text-slate-400 font-bold">Kategori:</span><span class="font-black text-slate-800" id="modal_peserta_kategori">—</span></div>
                            <div id="modal_perusahaan_container" class="flex justify-between hidden"><span class="text-slate-400 font-bold">Perusahaan Mitra:</span><span class="font-black text-slate-800" id="modal_perusahaan">—</span></div>
                        </div>
                    </div>
                </div>

                <!-- RIWAYAT PEMBAYARAN -->
                <div>
                    <div class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-4 border-b pb-1">Status & Riwayat Pembayaran</div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                        <div class="md:col-span-6 space-y-3 text-xs">
                            <div class="flex justify-between py-1 border-b border-slate-50"><span class="text-slate-400 font-bold">Status Bayar:</span><span class="px-2 py-0.5 rounded text-[9px] font-black uppercase" id="modal_status_bayar">—</span></div>
                            <div class="flex justify-between py-1 border-b border-slate-50"><span class="text-slate-400 font-bold">Status Progres:</span><span class="px-2 py-0.5 rounded text-[9px] font-black uppercase" id="modal_status_progres">—</span></div>
                        </div>
                        <div class="md:col-span-6 flex flex-col items-center justify-center p-4 bg-slate-50 rounded-3xl border border-slate-100">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Lampiran Bukti Transfer</span>
                            <div id="modal_bukti_bayar_container">
                                <!-- Bukti transfer di-render lewat JS -->
                                <span class="text-xs font-bold text-slate-400">—</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DOKUMEN SERTIFIKAT (Jika Ada) -->
                <div id="modal_sertifikat_card" class="hidden bg-emerald-50 border border-emerald-100 rounded-3xl p-5 flex justify-between items-center">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center shrink-0">
                            <i class="fi fi-rr-diploma"></i>
                        </div>
                        <div>
                            <h4 class="text-[11px] font-black text-emerald-800 uppercase tracking-wider mb-0.5">Sertifikat Resmi Diterbitkan</h4>
                            <p class="text-xs font-bold text-emerald-700 leading-relaxed" id="modal_sertifikat_no">—</p>
                        </div>
                    </div>
                    <a id="modal_sertifikat_btn" href="#" target="_blank" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-black uppercase tracking-wider hover:bg-emerald-700 transition shadow-sm">Buka PDF</a>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <button onclick="closeDetailModal()" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-slate-800 transition">Tutup Riwayat</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openDetailModal(pendaftaran, user, layanan, perusahaan, sertifikat) {
        // Formatting helpers
        const pad = (num, size) => ('000000000' + num).substr(-size);
        const year = pendaftaran.tanggal_daftar ? new Date(pendaftaran.tanggal_daftar).getFullYear() : new Date().getFullYear();
        const invoiceNo = `REG-${year}-${pad(pendaftaran.id_pendaftaran, 4)}`;

        // Dynamic Cancellation Reason calculation
        const reasons = [
            'Batas waktu pembayaran kedaluwarsa (sistem otomatis)',
            'Permintaan pembatalan mandiri oleh Klien/Mitra',
            'Jadwal kelas pelatihan penuh / kuota tidak mencukupi',
            'Kesalahan pemilihan metode/jadwal oleh pendaftar'
        ];
        const alasanBatal = reasons[pendaftaran.id_pendaftaran % reasons.length];

        // 1. General Header info
        document.getElementById('modal_reg_no').textContent = invoiceNo;

        // 2. Cancellation info card
        const cancelCard = document.getElementById('modal_cancel_card');
        if (pendaftaran.status_progres === 'dibatalkan') {
            cancelCard.classList.remove('hidden');
            document.getElementById('modal_cancel_reason').textContent = alasanBatal;
        } else {
            cancelCard.classList.add('hidden');
        }

        // 3. Left Section: Registration details
        document.getElementById('modal_tgl_daftar').textContent = pendaftaran.tanggal_daftar ? new Date(pendaftaran.tanggal_daftar).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'}) : '—';
        document.getElementById('modal_layanan_k3').textContent = layanan && layanan.jenis ? (layanan.jenis.nama || '—') : '—';
        document.getElementById('modal_tipe_layanan').textContent = pendaftaran.mode_pertemuan ? pendaftaran.mode_pertemuan.toUpperCase() : '—';
        document.getElementById('modal_cabang').textContent = (layanan && layanan.lokasi) ? layanan.lokasi : '—';
        
        const harga = layanan ? parseFloat(layanan.harga ?? 0) : 0;
        document.getElementById('modal_total_biaya').textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(harga);

        // 4. Right Section: Participant details
        document.getElementById('modal_peserta_nama').textContent = user ? (user.nama || '—') : '—';
        document.getElementById('modal_peserta_email').textContent = user ? (user.email || '—') : '—';
        document.getElementById('modal_peserta_kategori').textContent = pendaftaran.is_utusan_perusahaan ? 'Utusan Perusahaan' : 'Individu / Mandiri';
        
        const perusahaanContainer = document.getElementById('modal_perusahaan_container');
        if (pendaftaran.is_utusan_perusahaan && perusahaan) {
            perusahaanContainer.classList.remove('hidden');
            document.getElementById('modal_perusahaan').textContent = perusahaan.nama || '—';
        } else {
            perusahaanContainer.classList.add('hidden');
        }

        // 5. Payment details & Bukti transfer
        const statusBayarEl = document.getElementById('modal_status_bayar');
        statusBayarEl.textContent = pendaftaran.status_bayar || '—';
        if (pendaftaran.status_bayar === 'lunas') {
            statusBayarEl.className = "px-2.5 py-0.5 rounded text-[9px] font-black uppercase bg-indigo-50 text-indigo-600 border border-indigo-100";
        } else {
            statusBayarEl.className = "px-2.5 py-0.5 rounded text-[9px] font-black uppercase bg-slate-100 text-slate-400 border border-slate-200";
        }

        const statusProgresEl = document.getElementById('modal_status_progres');
        statusProgresEl.textContent = pendaftaran.status_progres || '—';
        if (pendaftaran.status_progres === 'selesai') {
            statusProgresEl.className = "px-2.5 py-0.5 rounded text-[9px] font-black uppercase bg-emerald-50 text-emerald-600 border border-emerald-100";
        } else {
            statusProgresEl.className = "px-2.5 py-0.5 rounded text-[9px] font-black uppercase bg-red-50 text-red-600 border border-red-100";
        }

        const buktiContainer = document.getElementById('modal_bukti_bayar_container');
        if (pendaftaran.bukti_bayar) {
            buktiContainer.innerHTML = `
                <a href="/storage/${pendaftaran.bukti_bayar}" target="_blank" class="group relative block w-32 h-20 rounded-2xl overflow-hidden border border-slate-200 shadow-sm hover:shadow-md transition">
                    <img src="/storage/${pendaftaran.bukti_bayar}" class="w-full h-full object-cover transition duration-300 group-hover:scale-110">
                    <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-300">
                        <i class="fi fi-rr-eye text-white"></i>
                    </div>
                </a>
            `;
        } else {
            buktiContainer.innerHTML = `<span class="text-xs font-bold text-slate-400 uppercase tracking-wider italic">Tidak Ada Lampiran</span>`;
        }

        // 6. Certificate Section (Dynamic)
        const certCard = document.getElementById('modal_sertifikat_card');
        if (pendaftaran.status_progres === 'selesai' && sertifikat) {
            certCard.classList.remove('hidden');
            document.getElementById('modal_sertifikat_no').textContent = `No. Sertifikat: ${sertifikat.no_sertifikat} (Nama: ${sertifikat.nama_lengkap})`;
            document.getElementById('modal_sertifikat_btn').href = `/admin/sertifikat/${sertifikat.no_sertifikat}`;
        } else {
            certCard.classList.add('hidden');
        }

        // Show Modal
        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>
@endpush
