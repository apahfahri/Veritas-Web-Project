@extends('layouts.subadmin')

@section('title', 'Kelola Proses Audit')
@section('page-title', 'Kelola Audit: ' . ($pendaftaran->perusahaan?->nama ?? 'B2B Client'))

@section('content')

{{-- ── TOP BREADCRUMB & HEADER ─────────────────────────────── --}}
<div class="mb-8 flex items-center justify-between">
    <a href="{{ route('subadmin.audit.index') }}" class="flex items-center gap-2 text-xs font-black text-slate-400 hover:text-slate-600 transition uppercase tracking-widest">
        <i class="fi fi-rr-arrow-left"></i> KEMBALI
    </a>
    <div class="text-right">
        <span class="text-xs text-slate-400 font-bold block">No. Pendaftaran:</span>
        <span class="inline-block bg-slate-100 text-slate-800 font-mono text-xs font-bold px-3 py-1.5 rounded-xl border border-slate-200 mt-0.5">{{ $pendaftaran->nomor_pendaftaran }}</span>
    </div>
</div>

{{-- ── FLASH MESSAGES ───────────────────────────────────────── --}}
@if(session('success'))
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-center gap-3">
        <span class="text-xl">✅</span>
        <p class="text-sm font-semibold">{{ session('success') }}</p>
    </div>
@endif

@if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl">
        <ul class="list-disc ml-5 text-sm font-semibold space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- LEFT / MAIN COLUMN                                             --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- ── STEPPER CARD ──────────────────────────────────────── --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 p-8 shadow-sm">
            <h3 class="text-base font-black text-slate-900 tracking-tight mb-8">Alur Tahapan Audit K3</h3>

            @php
                $stages = [
                    'meninjau'            => ['Tinjauan Awal',        'Subadmin meninjau pengajuan & kebutuhan audit perusahaan.'],
                    'disetujui'           => ['Konfirmasi',            'Permintaan audit disetujui, siap masuk tahap penjadwalan.'],
                    'dijadwalkan'         => ['Penjadwalan',           'Menentukan jadwal audit lapangan & auditor.'],
                    'menunggu_pelaksanaan' => ['Menunggu Pelaksanaan',  'Jadwal telah dikonfirmasi, menunggu pelaksanaan audit lapangan.'],
                    'menunggu_pembayaran' => ['Tagihan Dikirim',       'Audit selesai — tagihan dikirim ke klien.'],
                    'pembayaran_ditinjau' => ['Verifikasi Pembayaran', 'Bukti transfer diunggah klien, menunggu konfirmasi.'],
                    'selesai'             => ['Selesai',               'Seluruh proses audit & pembayaran berhasil selesai.'],
                ];

                $currentStage = strtolower($pendaftaran->status_progres);
                $stageKeys    = array_keys($stages);
                $currentIndex = array_search($currentStage, $stageKeys);
                if ($currentStage === 'dibatalkan') $currentIndex = -1;
            @endphp

            <div class="relative pl-8 border-l-2 border-slate-100 space-y-7">
                @foreach($stages as $key => $info)
                    @php
                        $keyIndex   = array_search($key, $stageKeys);
                        $isCompleted = ($currentIndex !== false && $keyIndex < $currentIndex);
                        $isActive    = ($currentStage === $key);

                        $bulletClass = 'bg-slate-100 border-slate-200 text-slate-400';
                        $titleClass  = 'text-slate-400 font-semibold';
                        if ($isCompleted) {
                            $bulletClass = 'bg-emerald-500 border-emerald-500 text-white';
                            $titleClass  = 'text-emerald-700 font-bold';
                        } elseif ($isActive) {
                            $bulletClass = 'bg-emerald-600 border-emerald-600 ring-4 ring-emerald-500/20 text-white';
                            $titleClass  = 'text-emerald-800 font-black';
                        }
                    @endphp
                    <div class="relative">
                        <span class="absolute -left-[41px] top-0.5 flex items-center justify-center w-6 h-6 rounded-full border-2 text-[10px] font-black {{ $bulletClass }}">
                            @if($isCompleted)✓@else{{ $keyIndex + 1 }}@endif
                        </span>
                        <div>
                            <span class="text-xs uppercase tracking-wider {{ $titleClass }}">{{ $info[0] }}</span>
                            @if($isActive)
                                <span class="ml-2 inline-block bg-emerald-100 text-emerald-700 text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full border border-emerald-200">Tahap Sekarang</span>
                            @endif
                            <p class="text-xs text-slate-400 mt-0.5 leading-relaxed">{{ $info[1] }}</p>
                        </div>
                    </div>
                @endforeach

                @if($currentStage === 'dibatalkan')
                    <div class="relative">
                        <span class="absolute -left-[41px] top-0.5 flex items-center justify-center w-6 h-6 rounded-full border-2 bg-rose-500 border-rose-500 text-white text-[10px]">✕</span>
                        <div>
                            <span class="text-xs uppercase tracking-wider text-rose-700 font-black">Dibatalkan</span>
                            <p class="text-xs text-slate-400 mt-0.5">Pengajuan audit ini telah ditolak atau dibatalkan.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── DYNAMIC ACTION CARD ────────────────────────────────── --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 p-8 shadow-sm">

            {{-- STAGE: MENINJAU --}}
            @if($pendaftaran->status_progres === 'meninjau')
                <div class="flex items-center gap-3 mb-6 pb-5 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-xl">👀</div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-widest">Tindakan Diperlukan</p>
                        <h3 class="text-base font-black text-slate-900">Tinjau Pengajuan Audit</h3>
                    </div>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed mb-6">
                    Harap tinjau kebutuhan audit, profil perusahaan, dan usulan tanggal di panel kanan. Jika data dinilai sesuai, setujui permintaan ini untuk lanjut ke tahap penjadwalan.
                </p>
                <div class="flex gap-3">
                    <form action="{{ route('subadmin.audit.confirm', $pendaftaran->id_pendaftaran) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-[#1E6B3D] hover:bg-[#24824A] text-white font-black text-sm px-6 py-4 rounded-2xl shadow-lg shadow-emerald-700/10 transition uppercase tracking-wider flex items-center justify-center gap-2">
                            <i class="fi fi-rr-check"></i>
                            Setujui & Konfirmasi Pengajuan
                        </button>
                    </form>
                    <form action="{{ route('subadmin.audit.reject-payment', $pendaftaran->id_pendaftaran) }}" method="POST">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Tolak dan batalkan pengajuan audit ini?')"
                                class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-bold text-sm px-6 py-4 rounded-2xl transition uppercase tracking-wider">
                            Tolak
                        </button>
                    </form>
                </div>
            @endif

            {{-- STAGE: DISETUJUI — Form Penjadwalan --}}
            @if($pendaftaran->status_progres === 'disetujui')
                <div class="flex items-center gap-3 mb-6 pb-5 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-xl">📅</div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-widest">Tindakan Diperlukan</p>
                        <h3 class="text-base font-black text-slate-900">Mulai Penjadwalan Audit</h3>
                    </div>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed mb-6">
                    Permintaan audit telah disetujui. Lanjutkan ke tahap berikutnya untuk menentukan tanggal, waktu, mode audit, dan tim auditor pendamping.
                </p>
                <form action="{{ route('subadmin.audit.start-scheduling', $pendaftaran->id_pendaftaran) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-[#1E6B3D] hover:bg-[#24824A] text-white font-black text-sm px-6 py-4 rounded-2xl shadow-lg shadow-emerald-700/10 transition uppercase tracking-wider flex items-center justify-center gap-2">
                        Lanjutkan ke Penjadwalan
                    </button>
                </form>
            @endif

            {{-- STAGE: DIJADWALKAN --}}
            @if($pendaftaran->status_progres === 'dijadwalkan')
                <div class="flex items-center gap-3 mb-6 pb-5 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-xl">📅</div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-widest">Tindakan Diperlukan</p>
                        <h3 class="text-base font-black text-slate-900">Tentukan Jadwal & Auditor</h3>
                    </div>
                </div>
                <p class="text-sm text-slate-500 leading-relaxed mb-6">
                    Isi detail jadwal pelaksanaan audit lapangan dan pilih tim auditor yang akan bertugas. Setelah disimpan, jadwal audit akan dikonfirmasi dan status otomatis beralih ke tahap pelaksanaan.
                </p>

                <form action="{{ route('subadmin.audit.schedule', $pendaftaran->id_pendaftaran) }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Audit <span class="text-red-500">*</span></label>
                            <input type="date" name="tgl_mulai" required
                                   value="{{ old('tgl_mulai', $pendaftaran->rencana_tanggal_mulai ? $pendaftaran->rencana_tanggal_mulai->format('Y-m-d') : '') }}"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-emerald-500/10 focus:outline-none focus:border-emerald-600 text-slate-700 font-semibold bg-slate-50">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Jam Pertemuan <span class="text-red-500">*</span></label>
                            <input type="time" name="jam_pertemuan" required
                                   value="{{ old('jam_pertemuan', $pendaftaran->jadwal?->jam_pertemuan) }}"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-emerald-500/10 focus:outline-none focus:border-emerald-600 text-slate-700 font-semibold bg-slate-50">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Mode Audit <span class="text-red-500">*</span></label>
                            <select name="mode_pertemuan" id="mode_pertemuan" required
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs bg-slate-50 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none focus:border-emerald-600 text-slate-700 font-semibold cursor-pointer"
                                    onchange="toggleFormLokasi(this.value)">
                                <option value="offline" {{ old('mode_pertemuan', $pendaftaran->mode_pertemuan) === 'offline' ? 'selected' : '' }}>🏢 Tatap Muka (On-Site)</option>
                                <option value="online" {{ old('mode_pertemuan', $pendaftaran->mode_pertemuan) === 'online' ? 'selected' : '' }}>🌐 Remote Audit (Online)</option>
                                <option value="hybrid" {{ old('mode_pertemuan', $pendaftaran->mode_pertemuan) === 'hybrid' ? 'selected' : '' }}>🔗 Hybrid</option>
                            </select>
                        </div>
                        <div id="lokasi-container" class="{{ old('mode_pertemuan', $pendaftaran->mode_pertemuan) === 'offline' ? '' : 'hidden' }}">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Lokasi Pelaksanaan Audit <span class="text-red-500">*</span></label>
                            <input type="text" name="lokasi" id="input-lokasi"
                                   value="{{ old('lokasi', $pendaftaran->jadwal?->lokasi) }}"
                                   placeholder="Tuliskan alamat lengkap perusahaan / area kerja..."
                                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-emerald-500/10 focus:outline-none focus:border-emerald-600 text-slate-700 font-semibold bg-slate-50">
                        </div>
                        <div id="link-meet-container" class="{{ old('mode_pertemuan', $pendaftaran->mode_pertemuan) !== 'offline' ? '' : 'hidden' }}">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Link Meeting Online <span class="text-red-500">*</span></label>
                            <input type="url" name="link_meet" id="input-link-meet"
                                   value="{{ old('link_meet', $pendaftaran->jadwal?->link_meet) }}"
                                   placeholder="https://zoom.us/j/..."
                                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-emerald-500/10 focus:outline-none focus:border-emerald-600 text-slate-700 font-semibold bg-slate-50">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-3">Pilih Auditor / Petugas K3 <span class="text-red-500">*</span></label>
                        <div class="grid md:grid-cols-2 gap-3 max-h-56 overflow-y-auto pr-1">
                            @foreach($allPemateri as $pemateri)
                                <label class="flex items-center gap-3 text-xs font-semibold text-slate-700 cursor-pointer p-3 bg-slate-50 hover:bg-slate-100 rounded-xl border border-slate-200/60 transition has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-200">
                                    <input type="checkbox" name="pemateri_ids[]" value="{{ $pemateri->id_pemateri }}"
                                           {{ in_array($pemateri->id_pemateri, old('pemateri_ids', $pendaftaran->jadwal?->pemateri->pluck('id_pemateri')->toArray() ?? [])) ? 'checked' : '' }}
                                           class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500 cursor-pointer">
                                    <div>
                                        <div class="font-bold text-slate-800">{{ $pemateri->nama_lengkap }}</div>
                                        <div class="text-[10px] text-slate-400 mt-0.5 truncate max-w-[200px]">{{ $pemateri->kompetensi }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-[#1E6B3D] hover:bg-[#24824A] text-white font-black text-sm px-6 py-4 rounded-2xl shadow-lg shadow-emerald-700/10 transition uppercase tracking-wider flex items-center justify-center gap-2">
                        <i class="fi fi-rr-calendar"></i>
                        Simpan Jadwal & Kirim Notifikasi ke Klien
                    </button>
                </form>
            @endif

            {{-- STAGE: MENUNGGU PELAKSANAAN --}}
            @if($pendaftaran->status_progres === 'menunggu_pelaksanaan')
                <div class="flex items-center gap-3 mb-6 pb-5 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-xl">📅</div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-widest">Jadwal Ditetapkan</p>
                        <h3 class="text-base font-black text-slate-900">Ringkasan Jadwal Audit</h3>
                    </div>
                </div>

                {{-- Jadwal Summary --}}
                <div class="bg-gradient-to-br from-emerald-50 to-slate-50 rounded-2xl p-5 border border-emerald-100/60 mb-6">
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400 font-bold uppercase block mb-0.5">Tanggal</span>
                            <span class="font-black text-slate-800 text-sm">
                                {{ $pendaftaran->rencana_tanggal_mulai ? $pendaftaran->rencana_tanggal_mulai->format('d M Y') : '-' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold uppercase block mb-0.5">Waktu</span>
                            <span class="font-black text-slate-800 text-sm">{{ $pendaftaran->jadwal?->jam_pertemuan ?? '-' }} WIB</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold uppercase block mb-0.5">Mode</span>
                            <span class="font-black text-slate-800 text-sm capitalize">{{ $pendaftaran->mode_pertemuan ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold uppercase block mb-0.5">
                                @if($pendaftaran->mode_pertemuan === 'offline') Lokasi Lapangan @else Link Meeting @endif
                            </span>
                            @if(in_array($pendaftaran->mode_pertemuan, ['online', 'hybrid']) && $pendaftaran->jadwal?->link_meet)
                                <a href="{{ $pendaftaran->jadwal->link_meet }}" target="_blank" class="font-bold text-emerald-600 hover:underline text-xs truncate block max-w-[180px]">
                                    🔗 Buka Link
                                </a>
                            @elseif($pendaftaran->mode_pertemuan === 'offline' && $pendaftaran->jadwal?->lokasi)
                                <span class="font-black text-slate-800 text-xs leading-tight block">{{ $pendaftaran->jadwal->lokasi }}</span>
                            @else
                                <span class="text-slate-400 text-xs">—</span>
                            @endif
                        </div>
                    </div>
                    @if($pendaftaran->jadwal?->pemateri && $pendaftaran->jadwal->pemateri->count() > 0)
                        <div class="pt-4 mt-4 border-t border-emerald-100/60">
                            <span class="text-slate-400 text-xs font-bold uppercase block mb-2">Auditor yang Bertugas:</span>
                            <div class="flex flex-wrap gap-2">
                                @foreach($pendaftaran->jadwal->pemateri as $pemat)
                                    <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-emerald-200">{{ $pemat->nama_lengkap }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100">
                    <h4 class="text-sm font-black text-slate-800 tracking-tight mb-3">Buat Tagihan Pembayaran & Selesaikan Audit</h4>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        Setelah pelaksanaan audit lapangan/visit selesai dilakukan, masukkan total tagihan resmi untuk jasa audit ini. Setelah dikirim, invoice otomatis dikirim ke email klien dan status berubah ke "Menunggu Pembayaran".
                    </p>

                    <form action="{{ route('subadmin.audit.finish', $pendaftaran->id_pendaftaran) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Total Nilai Tagihan Audit (Rp) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-bold">Rp</span>
                                <input type="text" id="harga-display"
                                       value="{{ $pendaftaran->jadwal?->harga ? 'Rp ' . number_format($pendaftaran->jadwal->harga, 0, ',', '.') : '' }}"
                                       placeholder="0"
                                       oninput="formatHarga(this)"
                                       class="w-full border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-xs focus:ring-4 focus:ring-emerald-500/10 focus:outline-none focus:border-emerald-600 text-slate-800 font-bold bg-slate-50 tracking-wide">
                                <input type="hidden" name="harga" id="harga-value" value="{{ $pendaftaran->jadwal?->harga ?? '' }}">
                            </div>
                        </div>

                        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex items-start gap-2.5">
                            <span class="text-lg shrink-0">⚠️</span>
                            <p class="text-[11px] text-amber-800 leading-relaxed font-medium">
                                Pastikan nilai tagihan sudah benar sebelum menyimpan. Invoice tagihan akan dikirim via email otomatis ke klien.
                            </p>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button type="submit" class="flex-1 bg-[#1E6B3D] hover:bg-[#24824A] text-white font-black text-xs px-6 py-4 rounded-xl shadow-lg shadow-emerald-700/10 transition uppercase tracking-wider flex items-center justify-center gap-2">
                                <i class="fi fi-rr-check-circle"></i>
                                Selesaikan & Kirim Tagihan
                            </button>
                            <button type="button" onclick="toggleEditJadwal()"
                                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs px-5 py-4 rounded-xl transition uppercase tracking-wider flex items-center gap-2">
                                <i class="fi fi-rr-edit"></i>
                                Ubah Jadwal
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Form Edit Jadwal --}}
                <div id="edit-jadwal-form" class="hidden mt-6 pt-6 border-t border-slate-100">
                    <p class="text-xs font-bold text-slate-700 mb-4 uppercase tracking-wider">✏️ Edit Jadwal Audit</p>
                    <form action="{{ route('subadmin.audit.schedule', $pendaftaran->id_pendaftaran) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Tanggal *</label>
                                <input type="date" name="tgl_mulai" required
                                       value="{{ $pendaftaran->rencana_tanggal_mulai ? $pendaftaran->rencana_tanggal_mulai->format('Y-m-d') : '' }}"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-emerald-500/10 focus:outline-none focus:border-emerald-600 text-slate-700 font-semibold bg-slate-50">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Jam *</label>
                                <input type="time" name="jam_pertemuan" required
                                       value="{{ $pendaftaran->jadwal?->jam_pertemuan }}"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-emerald-500/10 focus:outline-none focus:border-emerald-600 text-slate-700 font-semibold bg-slate-50">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Mode *</label>
                                <select name="mode_pertemuan" id="edit_mode_pertemuan" required
                                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs bg-slate-50 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none focus:border-emerald-600 text-slate-700 font-semibold"
                                        onchange="toggleEditLokasi(this.value)">
                                    <option value="offline" {{ $pendaftaran->mode_pertemuan === 'offline' ? 'selected' : '' }}>🏢 Tatap Muka</option>
                                    <option value="online" {{ $pendaftaran->mode_pertemuan === 'online' ? 'selected' : '' }}>🌐 Online</option>
                                    <option value="hybrid" {{ $pendaftaran->mode_pertemuan === 'hybrid' ? 'selected' : '' }}>🔗 Hybrid</option>
                                </select>
                            </div>
                            <div id="edit-lokasi-container" class="{{ $pendaftaran->mode_pertemuan === 'offline' ? '' : 'hidden' }}">
                                <label class="block text-xs font-bold text-slate-600 mb-1">Lokasi *</label>
                                <input type="text" name="lokasi" id="edit-input-lokasi"
                                       value="{{ $pendaftaran->jadwal?->lokasi }}"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-emerald-500/10 focus:outline-none focus:border-emerald-600 bg-slate-50">
                            </div>
                            <div id="edit-link-container" class="{{ $pendaftaran->mode_pertemuan !== 'offline' ? '' : 'hidden' }}">
                                <label class="block text-xs font-bold text-slate-600 mb-1">Link Meeting *</label>
                                <input type="url" name="link_meet" id="edit-input-link"
                                       value="{{ $pendaftaran->jadwal?->link_meet }}"
                                       placeholder="https://zoom.us/j/..."
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-emerald-500/10 focus:outline-none focus:border-emerald-600 bg-slate-50">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2">Auditor yang Bertugas *</label>
                            <div class="grid md:grid-cols-2 gap-2 max-h-48 overflow-y-auto pr-1">
                                @foreach($allPemateri as $pemateri)
                                    <label class="flex items-center gap-2 text-xs cursor-pointer p-2.5 bg-slate-50 hover:bg-slate-100 rounded-xl border border-slate-200/60 transition has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-200">
                                        <input type="checkbox" name="pemateri_ids[]" value="{{ $pemateri->id_pemateri }}"
                                               {{ in_array($pemateri->id_pemateri, $pendaftaran->jadwal?->pemateri->pluck('id_pemateri')->toArray() ?? []) ? 'checked' : '' }}
                                               class="w-3.5 h-3.5 text-emerald-600 rounded">
                                        <span class="font-semibold text-slate-700">{{ $pemateri->nama_lengkap }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-5 py-3.5 rounded-xl transition uppercase tracking-wider">
                                Simpan Perubahan Jadwal
                            </button>
                            <button type="button" onclick="toggleEditJadwal()" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs px-5 py-3.5 rounded-xl transition">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- STAGE: MENUNGGU PEMBAYARAN --}}
            @if($pendaftaran->status_progres === 'menunggu_pembayaran')
                <div class="flex items-center gap-3 mb-6 pb-5 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-xl">💳</div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-widest">Menunggu Klien</p>
                        <h3 class="text-base font-black text-slate-900">Tagihan Telah Dikirim</h3>
                    </div>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed mb-5">
                    Invoice telah dikirim ke email klien. Menunggu klien mengunggah bukti transfer pembayaran.
                </p>
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <span class="text-xs text-slate-400 font-bold uppercase block mb-1">Total Tagihan</span>
                            <span class="text-2xl font-black text-slate-900">Rp {{ number_format($pendaftaran->jadwal?->harga ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-slate-400 font-bold uppercase block mb-1">Status Bayar</span>
                            <span class="inline-block bg-red-100 text-red-700 text-xs font-black px-3 py-1.5 rounded-xl border border-red-200 uppercase tracking-wider">
                                Belum Lunas
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- STAGE: PEMBAYARAN DITINJAU --}}
            @if($pendaftaran->status_progres === 'pembayaran_ditinjau')
                <div class="flex items-center gap-3 mb-6 pb-5 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-xl">🔍</div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-widest">Tindakan Diperlukan</p>
                        <h3 class="text-base font-black text-slate-900">Verifikasi Bukti Pembayaran</h3>
                    </div>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed mb-5">
                    Klien telah mengunggah foto bukti transfer. Harap verifikasi dengan mencocokkan nominal pada rekening koran sebelum mengkonfirmasi lunas.
                </p>

                @if($pendaftaran->bukti_bayar)
                    <div class="mb-5">
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Foto Bukti Transfer:</p>
                        <div class="relative group cursor-pointer overflow-hidden rounded-2xl border border-slate-200 shadow-sm max-w-sm"
                             onclick="window.open('{{ asset('uploads/pembayaran/' . $pendaftaran->bukti_bayar) }}', '_blank')">
                            <img src="{{ asset('uploads/pembayaran/' . $pendaftaran->bukti_bayar) }}"
                                 alt="Bukti Pembayaran"
                                 class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                <span class="bg-white/20 backdrop-blur-md text-white text-xs font-bold px-4 py-2 rounded-full border border-white/30">
                                    🔍 Lihat Resolusi Penuh
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 mb-5">
                    <span class="text-xs text-slate-400 font-bold uppercase block mb-1">Total Tagihan yang Harus Dibayar</span>
                    <span class="text-xl font-black text-slate-900">Rp {{ number_format($pendaftaran->jadwal?->harga ?? 0, 0, ',', '.') }}</span>
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('subadmin.audit.confirm-payment', $pendaftaran->id_pendaftaran) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Konfirmasi pembayaran sebagai LUNAS dan selesaikan audit ini?')"
                                class="w-full bg-[#1E6B3D] hover:bg-[#24824A] text-white font-black text-sm px-6 py-4 rounded-2xl shadow-lg shadow-emerald-700/10 transition uppercase tracking-wider flex items-center justify-center gap-2">
                            <i class="fi fi-rr-check"></i>
                            Konfirmasi Pembayaran Lunas
                        </button>
                    </form>
                    <form action="{{ route('subadmin.audit.reject-payment', $pendaftaran->id_pendaftaran) }}" method="POST">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Tolak bukti pembayaran ini? Status akan dikembalikan.')"
                                class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-bold text-sm px-6 py-4 rounded-2xl transition uppercase tracking-wider">
                            Bukti Tidak Valid
                        </button>
                    </form>
                </div>
            @endif

            {{-- STAGE: SELESAI --}}
            @if($pendaftaran->status_progres === 'selesai')
                <div class="p-8 bg-gradient-to-br from-emerald-50 to-green-50 border border-emerald-200 rounded-2xl text-center space-y-4">
                    <span class="text-5xl block">🏆</span>
                    <h4 class="text-base font-black text-emerald-800 uppercase tracking-wider">Audit Selesai & Lunas</h4>
                    <p class="text-sm text-emerald-700 max-w-sm mx-auto leading-relaxed">
                        Seluruh proses — dari pendaftaran, penjadwalan, pelaksanaan lapangan, hingga pembayaran — telah berhasil diselesaikan.
                    </p>
                    <div class="pt-2 border-t border-emerald-200/60">
                        <span class="text-xs text-emerald-600 font-semibold">Total Nilai Audit: </span>
                        <span class="text-sm font-black text-emerald-800">Rp {{ number_format($pendaftaran->jadwal?->harga ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endif

            {{-- STAGE: DIBATALKAN --}}
            @if($pendaftaran->status_progres === 'dibatalkan')
                <div class="p-8 bg-rose-50 border border-rose-200 rounded-2xl text-center space-y-3">
                    <span class="text-5xl block">❌</span>
                    <h4 class="text-base font-black text-rose-800 uppercase tracking-wider">Permintaan Dibatalkan</h4>
                    <p class="text-sm text-rose-700 max-w-sm mx-auto leading-relaxed">
                        Pengajuan layanan audit ini telah ditolak atau dibatalkan dari sistem.
                    </p>
                </div>
            @endif

        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- RIGHT / SIDEBAR COLUMN                                         --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <div class="space-y-6">

        {{-- Profil Perusahaan --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm">
            <h3 class="text-sm font-black text-slate-900 tracking-tight mb-5 flex items-center gap-2">
                <i class="fi fi-rr-building text-emerald-600"></i>
                Profil Perusahaan Klien
            </h3>
            <div class="space-y-4">
                @foreach([
                    ['Nama Perusahaan', $pendaftaran->perusahaan?->nama ?? '—', true],
                    ['Sektor Industri', $pendaftaran->perusahaan?->sektor_industri ?? '—', false],
                    ['Jumlah Karyawan', $pendaftaran->perusahaan?->jumlah_karyawan ? $pendaftaran->perusahaan->jumlah_karyawan . ' Karyawan' : '—', false],
                    ['Alamat', $pendaftaran->perusahaan?->alamat ?? '—', false],
                ] as [$label, $value, $large])
                <div>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-0.5">{{ $label }}</span>
                    <span class="font-bold text-slate-800 {{ $large ? 'text-sm' : 'text-xs' }} leading-snug block">{{ $value }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Data PIC --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm">
            <h3 class="text-sm font-black text-slate-900 tracking-tight mb-5 flex items-center gap-2">
                <i class="fi fi-rr-user text-slate-500"></i>
                PIC / Penghubung
            </h3>
            <div class="space-y-4">
                @php
                    $jabatanPIC = $pendaftaran->perusahaan?->klienPerusahaan?->where('id_user', $pendaftaran->id_user)->first()?->jabatan ?? 'PIC';
                @endphp
                @foreach([
                    ['Nama', $pendaftaran->user?->nama ?? '—'],
                    ['Jabatan', $jabatanPIC],
                    ['WhatsApp', $pendaftaran->user?->no_telp ?? '—'],
                    ['Email', $pendaftaran->user?->email ?? '—'],
                ] as [$label, $value])
                <div>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-0.5">{{ $label }}</span>
                    <span class="font-bold text-slate-700 text-xs leading-snug block break-all">{{ $value }}</span>
                </div>
                @endforeach
                <div class="pt-3 border-t border-slate-100 flex gap-2">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pendaftaran->user?->no_telp ?? '') }}"
                       target="_blank"
                       class="flex-1 bg-[#25D366]/10 hover:bg-[#25D366]/20 text-[#128C7E] text-xs font-bold px-3 py-2.5 rounded-xl flex items-center justify-center gap-1.5 transition border border-[#25D366]/20">
                        <i class="fi fi-brands-whatsapp fill-[#25D366]"></i>
                        WhatsApp
                    </a>
                    <a href="mailto:{{ $pendaftaran->user?->email }}"
                       class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-3 py-2.5 rounded-xl flex items-center justify-center gap-1.5 transition">
                        <i class="fi fi-rr-envelope"></i>
                        Email
                    </a>
                </div>
            </div>
        </div>

        {{-- Pengajuan Awal --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm">
            <h3 class="text-sm font-black text-slate-900 tracking-tight mb-5">📋 Detail Pengajuan Awal</h3>
            <div class="space-y-4">
                @foreach([
                    ['Jenis Layanan', $pendaftaran->jadwal?->jenis?->nama ?? '—'],
                    ['Usulan Tanggal', $pendaftaran->rencana_tanggal_mulai ? $pendaftaran->rencana_tanggal_mulai->format('d M Y') : '-'],
                    ['Mode Rencana', strtoupper($pendaftaran->mode_pertemuan ?? 'offline')],
                ] as [$label, $value])
                <div>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-0.5">{{ $label }}</span>
                    <span class="font-bold text-slate-700 text-xs block">{{ $value }}</span>
                </div>
                @endforeach
                @if($pendaftaran->jadwal?->deskripsi)
                <div>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Catatan Klien</span>
                    <p class="font-medium text-slate-600 text-xs leading-relaxed italic bg-slate-50 p-3 rounded-xl border border-slate-100">"{{ $pendaftaran->jadwal->deskripsi }}"</p>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function toggleFormLokasi(val) {
        const lokasiContainer   = document.getElementById('lokasi-container');
        const linkMeetContainer = document.getElementById('link-meet-container');
        const inputLokasi       = document.getElementById('input-lokasi');
        const inputLinkMeet     = document.getElementById('input-link-meet');

        if (val === 'offline') {
            lokasiContainer.classList.remove('hidden');
            linkMeetContainer.classList.add('hidden');
            if (inputLokasi) inputLokasi.required = true;
            if (inputLinkMeet) { inputLinkMeet.required = false; inputLinkMeet.value = ''; }
        } else {
            lokasiContainer.classList.add('hidden');
            linkMeetContainer.classList.remove('hidden');
            if (inputLokasi) { inputLokasi.required = false; inputLokasi.value = ''; }
            if (inputLinkMeet) inputLinkMeet.required = true;
        }
    }

    function toggleEditJadwal() {
        const form = document.getElementById('edit-jadwal-form');
        if (form) form.classList.toggle('hidden');
    }

    function toggleEditLokasi(val) {
        const lokasiEl = document.getElementById('edit-lokasi-container');
        const linkEl   = document.getElementById('edit-link-container');
        const lokasiInput = document.getElementById('edit-input-lokasi');
        const linkInput   = document.getElementById('edit-input-link');

        if (val === 'offline') {
            lokasiEl?.classList.remove('hidden');
            linkEl?.classList.add('hidden');
            if (lokasiInput) lokasiInput.required = true;
            if (linkInput) { linkInput.required = false; linkInput.value = ''; }
        } else {
            lokasiEl?.classList.add('hidden');
            linkEl?.classList.remove('hidden');
            if (lokasiInput) { lokasiInput.required = false; lokasiInput.value = ''; }
            if (linkInput) linkInput.required = true;
        }
    }

    // Format harga Rupiah otomatis
    function formatHarga(input) {
        let raw = input.value.replace(/[^0-9]/g, '');
        document.getElementById('harga-value').value = raw;
        if (raw) {
            input.value = new Intl.NumberFormat('id-ID').format(parseInt(raw));
        }
    }

    // Init on load
    document.addEventListener('DOMContentLoaded', function () {
        const modeSelect = document.getElementById('mode_pertemuan');
        if (modeSelect) toggleFormLokasi(modeSelect.value);

        // Init harga display if it already has a value
        const hargaDisplay = document.getElementById('harga-display');
        if (hargaDisplay && hargaDisplay.value) {
            // Already formatted from PHP
        }
    });
</script>
@endpush
@endsection
