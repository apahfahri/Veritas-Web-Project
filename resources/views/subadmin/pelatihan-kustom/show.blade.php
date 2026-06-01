@extends('layouts.subadmin')

@section('title', 'Kelola Pelatihan Kustom')
@section('page-title', 'Kelola Pelatihan Kustom: ' . ($pendaftaran->perusahaan?->nama ?? 'B2B Client'))

@section('content')

{{-- ── TOP BREADCRUMB & HEADER ─────────────────────────────── --}}
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="{{ route('subadmin.pelatihan-kustom.index') }}" class="p-2.5 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-slate-900 transition shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <p class="text-xs text-slate-500 font-extrabold uppercase tracking-widest">Pelatihan Kustom B2B (Bespoke)</p>
            <h2 class="text-xl font-black text-slate-900 tracking-tight">Detail Proses Pelatihan Kustom</h2>
        </div>
    </div>
    <div class="text-right">
        <span class="text-xs text-slate-400 font-bold block">No. Pendaftaran:</span>
        <span class="inline-block bg-slate-100 text-slate-800 font-mono text-xs font-bold px-3 py-1.5 rounded-xl border border-slate-200 mt-0.5">{{ $pendaftaran->nomor_pendaftaran }}</span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- LEFT / MAIN COLUMN                                             --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- ── STEPPER CARD ──────────────────────────────────────── --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 p-8 shadow-sm">
            <h3 class="text-base font-black text-slate-900 tracking-tight mb-8">Alur Tahapan Pelatihan Kustom</h3>

            @php
                $stages = [
                    'meninjau'            => ['Tinjauan Awal',        'Subadmin meninjau registrasi awal pelatihan.'],
                    'disetujui'           => ['Disetujui',            'Permintaan disetujui, siap masuk tahap penjadwalan.'],
                    'dijadwalkan'         => ['Penjadwalan',           'Menentukan tanggal pelatihan, jam, & instruktur pendamping.'],
                    'menunggu_pelaksanaan' => ['Menunggu Pelaksanaan',  'Jadwal & materi disepakati, menunggu pelatihan dilaksanakan.'],
                    'menunggu_pembayaran' => ['Tagihan Dikirim',       'Pelatihan selesai dilaksanakan — invoice dikirim ke perusahaan.'],
                    'pembayaran_ditinjau' => ['Verifikasi Pembayaran', 'Klien telah mengunggah bukti transfer, menunggu konfirmasi subadmin.'],
                    'selesai'             => ['Selesai',               'Seluruh tahapan pelatihan kustom dan administrasi pembayaran selesai.'],
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
                            $bulletClass = 'bg-cyan-600 border-cyan-600 ring-4 ring-cyan-500/20 text-white';
                            $titleClass  = 'text-cyan-800 font-black';
                        }
                    @endphp
                    <div class="relative">
                        <span class="absolute -left-[41px] top-0.5 flex items-center justify-center w-6 h-6 rounded-full border-2 text-[10px] font-black {{ $bulletClass }}">
                            @if($isCompleted)✓@else{{ $keyIndex + 1 }}@endif
                        </span>
                        <div>
                            <span class="text-xs uppercase tracking-wider {{ $titleClass }}">{{ $info[0] }}</span>
                            @if($isActive)
                                <span class="ml-2 inline-block bg-cyan-100 text-cyan-700 text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full border border-cyan-200">Tahap Sekarang</span>
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
                            <p class="text-xs text-slate-400 mt-0.5">Pelatihan kustom ini telah ditolak atau dibatalkan.</p>
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
                        <h3 class="text-base font-black text-slate-900">Tinjau Registrasi Pelatihan Kustom</h3>
                    </div>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed mb-6">
                    Tinjau detail topik pelatihan, data peserta, dan tanggal usulan pada panel kanan. Jika dinilai valid, setujui permohonan ini untuk lanjut ke proses penjadwalan formal.
                </p>
                <div class="flex gap-3">
                    <form action="{{ route('subadmin.pelatihan-kustom.confirm', $pendaftaran->id_pendaftaran) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-[#1E6B3D] hover:bg-[#24824A] text-white font-black text-xs px-6 py-4 rounded-2xl shadow-lg shadow-emerald-700/10 transition uppercase tracking-wider flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Setujui & Lanjutkan
                        </button>
                    </form>
                    <form action="{{ route('subadmin.pelatihan-kustom.reject-payment', $pendaftaran->id_pendaftaran) }}" method="POST">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Batalkan dan tolak pendaftaran pelatihan kustom ini?')"
                                class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-bold text-xs px-6 py-4 rounded-2xl transition uppercase tracking-wider">
                            Tolak
                        </button>
                    </form>
                </div>
            @endif

            {{-- STAGE: DISETUJUI --}}
            @if($pendaftaran->status_progres === 'disetujui')
                <div class="flex items-center gap-3 mb-6 pb-5 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-xl">📅</div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-widest">Tindakan Diperlukan</p>
                        <h3 class="text-base font-black text-slate-900">Mulai Penjadwalan Pelatihan</h3>
                    </div>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed mb-6">
                    Pendaftaran pelatihan kustom telah disetujui. Silakan masuk ke tahap penjadwalan untuk menetapkan jam, tanggal pelaksanaan, lokasi (atau link meeting online), serta instruktur (pemateri).
                </p>
                <form action="{{ route('subadmin.pelatihan-kustom.start-scheduling', $pendaftaran->id_pendaftaran) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-[#1E6B3D] hover:bg-[#24824A] text-white font-black text-xs px-6 py-4 rounded-2xl shadow-lg shadow-emerald-700/10 transition uppercase tracking-wider flex items-center justify-center gap-2">
                        Buka Form Penjadwalan
                    </button>
                </form>
            @endif

            {{-- STAGE: DIJADWALKAN --}}
            @if($pendaftaran->status_progres === 'dijadwalkan')
                <div class="flex items-center gap-3 mb-6 pb-5 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-xl">📅</div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-widest">Tindakan Diperlukan</p>
                        <h3 class="text-base font-black text-slate-900">Tentukan Jadwal & Pemateri</h3>
                    </div>
                </div>
                <p class="text-sm text-slate-500 leading-relaxed mb-6">
                    Tentukan tanggal pelaksanaan, jam pertemuan, mode pelaksanaan, dan tugaskan pemateri/trainer. Setelah disimpan, notifikasi jadwal beserta tautan akan dikirimkan otomatis ke email PIC perusahaan klien.
                </p>

                <form action="{{ route('subadmin.pelatihan-kustom.schedule', $pendaftaran->id_pendaftaran) }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <input type="date" name="tgl_mulai" required
                                   value="{{ old('tgl_mulai', $pendaftaran->rencana_tanggal_mulai ? $pendaftaran->rencana_tanggal_mulai->format('Y-m-d') : '') }}"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 text-slate-700 font-semibold bg-slate-50">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Selesai <span class="text-red-500">*</span></label>
                            <input type="date" name="tgl_selesai" required
                                   value="{{ old('tgl_selesai', $pendaftaran->rencana_tanggal_selesai ? $pendaftaran->rencana_tanggal_selesai->format('Y-m-d') : '') }}"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 text-slate-700 font-semibold bg-slate-50">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Jam Mulai <span class="text-red-500">*</span></label>
                            <input type="time" name="jam_pertemuan" required
                                   value="{{ old('jam_pertemuan', $pendaftaran->jadwal?->jam_pertemuan) }}"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 text-slate-700 font-semibold bg-slate-50">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Mode Pelaksanaan <span class="text-red-500">*</span></label>
                            <select name="mode_pertemuan" id="mode_pertemuan" required
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs bg-slate-50 focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 text-slate-700 font-semibold cursor-pointer"
                                    onchange="toggleFormLokasi(this.value)">
                                <option value="online" {{ old('mode_pertemuan', $pendaftaran->mode_pertemuan) === 'online' ? 'selected' : '' }}>🌐 Online (Classroom/Meet)</option>
                                <option value="offline" {{ old('mode_pertemuan', $pendaftaran->mode_pertemuan) === 'offline' ? 'selected' : '' }}>🏢 Offline (In-House Training)</option>
                                <option value="hybrid" {{ old('mode_pertemuan', $pendaftaran->mode_pertemuan) === 'hybrid' ? 'selected' : '' }}>🔗 Hybrid</option>
                            </select>
                        </div>
                        <div id="lokasi-container" class="{{ old('mode_pertemuan', $pendaftaran->mode_pertemuan) === 'offline' ? '' : 'hidden' }}">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Lokasi In-House (Fisik) <span class="text-red-500">*</span></label>
                            <input type="text" name="lokasi" id="input-lokasi"
                                   value="{{ old('lokasi', $pendaftaran->jadwal?->lokasi) }}"
                                   placeholder="Contoh: Gedung Rapat Utama PT Klien"
                                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 text-slate-700 font-semibold bg-slate-50">
                        </div>
                        <div id="link-meet-container" class="{{ old('mode_pertemuan', $pendaftaran->mode_pertemuan) !== 'offline' ? '' : 'hidden' }}">
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Link Meeting Online <span class="text-red-500">*</span></label>
                            <input type="url" name="link_meet" id="input-link-meet"
                                   value="{{ old('link_meet', $pendaftaran->jadwal?->link_meet) }}"
                                   placeholder="https://zoom.us/j/..."
                                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 text-slate-700 font-semibold bg-slate-50">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-3">Tugaskan Instruktur / Pemateri <span class="text-red-500">*</span></label>
                        <div class="grid md:grid-cols-2 gap-3 max-h-56 overflow-y-auto pr-1">
                            @foreach($pemateris as $pemateri)
                                <label class="flex items-center gap-3 text-xs font-semibold text-slate-700 cursor-pointer p-3 bg-slate-50 hover:bg-slate-100 rounded-xl border border-slate-200/60 transition has-[:checked]:bg-cyan-50 has-[:checked]:border-cyan-200">
                                    <input type="checkbox" name="pemateri_ids[]" value="{{ $pemateri->id_pemateri }}"
                                           {{ in_array($pemateri->id_pemateri, old('pemateri_ids', $pendaftaran->jadwal?->pemateri->pluck('id_pemateri')->toArray() ?? [])) ? 'checked' : '' }}
                                           class="w-4 h-4 text-cyan-600 rounded border-slate-300 focus:ring-cyan-500 cursor-pointer">
                                    <div>
                                        <div class="font-bold text-slate-800">{{ $pemateri->nama_lengkap }}</div>
                                        <div class="text-[10px] text-slate-400 mt-0.5 truncate max-w-[200px]">{{ $pemateri->kompetensi }}</div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-[#1E6B3D] hover:bg-[#24824A] text-white font-black text-xs px-6 py-4 rounded-2xl shadow-lg shadow-emerald-700/10 transition uppercase tracking-wider flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Simpan Jadwal & Kirim Email ke PIC Klien
                    </button>
                </form>
            @endif

            {{-- STAGE: MENUNGGU PELAKSANAAN --}}
            @if($pendaftaran->status_progres === 'menunggu_pelaksanaan')
                <div class="flex items-center gap-3 mb-6 pb-5 border-b border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-xl">📅</div>
                    <div>
                        <p class="text-xs text-slate-400 font-semibold uppercase tracking-widest">Jadwal Ditetapkan</p>
                        <h3 class="text-base font-black text-slate-900">Jadwal Pelatihan Kustom</h3>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-indigo-50 to-slate-50 rounded-2xl p-5 border border-indigo-100/60 mb-6">
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400 font-bold uppercase block mb-0.5">Tanggal</span>
                            <span class="font-black text-slate-800 text-sm">
                                {{ $pendaftaran->rencana_tanggal_mulai ? $pendaftaran->rencana_tanggal_mulai->format('d M Y') : '-' }}
                                @if($pendaftaran->rencana_tanggal_selesai && $pendaftaran->rencana_tanggal_selesai != $pendaftaran->rencana_tanggal_mulai)
                                    s/d {{ $pendaftaran->rencana_tanggal_selesai->format('d M Y') }}
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold uppercase block mb-0.5">Waktu Mulai</span>
                            <span class="font-black text-slate-800 text-sm">{{ $pendaftaran->jadwal?->jam_pertemuan ?? '-' }} WIB</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold uppercase block mb-0.5">Mode</span>
                            <span class="font-black text-slate-800 text-sm capitalize">{{ $pendaftaran->mode_pertemuan ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold uppercase block mb-0.5">
                                @if($pendaftaran->mode_pertemuan === 'offline') Lokasi In-House @else Tautan Kelas @endif
                            </span>
                            @if(in_array($pendaftaran->mode_pertemuan, ['online', 'hybrid']) && $pendaftaran->jadwal?->link_meet)
                                <a href="{{ $pendaftaran->jadwal->link_meet }}" target="_blank" class="font-bold text-cyan-600 hover:underline text-xs truncate block max-w-[180px]">
                                    🔗 Buka Tautan Kelas
                                </a>
                            @elseif($pendaftaran->mode_pertemuan === 'offline' && $pendaftaran->jadwal?->lokasi)
                                <span class="font-black text-slate-800 text-xs leading-tight block">{{ $pendaftaran->jadwal->lokasi }}</span>
                            @else
                                <span class="text-slate-400 text-xs">—</span>
                            @endif
                        </div>
                    </div>
                    @if($pendaftaran->jadwal?->pemateri && $pendaftaran->jadwal->pemateri->count() > 0)
                        <div class="pt-4 mt-4 border-t border-indigo-100/60">
                            <span class="text-slate-400 text-xs font-bold uppercase block mb-2">Instruktur Yang Bertugas:</span>
                            <div class="flex flex-wrap gap-2">
                                @foreach($pendaftaran->jadwal->pemateri as $pemat)
                                    <span class="bg-cyan-100 text-cyan-800 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-cyan-200">{{ $pemat->nama_lengkap }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100">
                    <h4 class="text-sm font-black text-slate-800 tracking-tight mb-3">Terbitkan Invoice (Tagihan) Pasca-Pelaksanaan</h4>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        Masukkan total biaya final pelatihan kustom setelah sesi/training selesai diselenggarakan. Tombol ini akan mengirimkan tagihan resmi berupa email invoice ke PIC perusahaan klien.
                    </p>

                    <form action="{{ route('subadmin.pelatihan-kustom.finish', $pendaftaran->id_pendaftaran) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Nilai Tagihan Final Pelatihan (Rp) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-bold">Rp</span>
                                <input type="text" id="harga-display"
                                       value="{{ $pendaftaran->jadwal?->harga ? 'Rp ' . number_format($pendaftaran->jadwal->harga, 0, ',', '.') : '' }}"
                                       placeholder="0"
                                       oninput="formatHarga(this)"
                                       class="w-full border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-xs focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 text-slate-800 font-bold bg-slate-50 tracking-wide">
                                <input type="hidden" name="harga" id="harga-value" value="{{ $pendaftaran->jadwal?->harga ?? '' }}">
                            </div>
                        </div>

                        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 flex items-start gap-2.5">
                            <span class="text-lg shrink-0">⚠️</span>
                            <p class="text-[11px] text-amber-800 leading-relaxed font-medium">
                                Pastikan nominal tagihan pelatihan kustom sudah disetujui bersama mitra sebelum mengirim invoice ini.
                            </p>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button type="submit" class="flex-1 bg-[#1E6B3D] hover:bg-[#24824A] text-white font-black text-xs px-6 py-4 rounded-xl shadow-lg shadow-emerald-700/10 transition uppercase tracking-wider flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Kirim Invoice ke Klien
                            </button>
                            <button type="button" onclick="toggleEditJadwal()"
                                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs px-5 py-4 rounded-xl transition uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Ubah Jadwal
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Form Edit Jadwal --}}
                <div id="edit-jadwal-form" class="hidden mt-6 pt-6 border-t border-slate-100">
                    <p class="text-xs font-bold text-slate-700 mb-4 uppercase tracking-wider">✏️ Edit Jadwal & Pemateri</p>
                    <form action="{{ route('subadmin.pelatihan-kustom.schedule', $pendaftaran->id_pendaftaran) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Tanggal Mulai *</label>
                                <input type="date" name="tgl_mulai" required
                                       value="{{ $pendaftaran->rencana_tanggal_mulai ? $pendaftaran->rencana_tanggal_mulai->format('Y-m-d') : '' }}"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 text-slate-700 font-semibold bg-slate-50">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Tanggal Selesai *</label>
                                <input type="date" name="tgl_selesai" required
                                       value="{{ $pendaftaran->rencana_tanggal_selesai ? $pendaftaran->rencana_tanggal_selesai->format('Y-m-d') : ($pendaftaran->rencana_tanggal_mulai ? $pendaftaran->rencana_tanggal_mulai->format('Y-m-d') : '') }}"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 text-slate-700 font-semibold bg-slate-50">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Jam Mulai *</label>
                                <input type="time" name="jam_pertemuan" required
                                       value="{{ $pendaftaran->jadwal?->jam_pertemuan }}"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 text-slate-700 font-semibold bg-slate-50">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-600 mb-1">Mode *</label>
                                <select name="mode_pertemuan" id="edit_mode_pertemuan" required
                                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs bg-slate-50 focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 text-slate-700 font-semibold"
                                        onchange="toggleEditLokasi(this.value)">
                                    <option value="online" {{ $pendaftaran->mode_pertemuan === 'online' ? 'selected' : '' }}>🌐 Online</option>
                                    <option value="offline" {{ $pendaftaran->mode_pertemuan === 'offline' ? 'selected' : '' }}>🏢 Offline</option>
                                    <option value="hybrid" {{ $pendaftaran->mode_pertemuan === 'hybrid' ? 'selected' : '' }}>🔗 Hybrid</option>
                                </select>
                            </div>
                            <div id="edit-lokasi-container" class="{{ $pendaftaran->mode_pertemuan === 'offline' ? '' : 'hidden' }}">
                                <label class="block text-xs font-bold text-slate-600 mb-1">Lokasi In-House *</label>
                                <input type="text" name="lokasi" id="edit-input-lokasi"
                                       value="{{ $pendaftaran->jadwal?->lokasi }}"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 bg-slate-50">
                            </div>
                            <div id="edit-link-container" class="{{ $pendaftaran->mode_pertemuan !== 'offline' ? '' : 'hidden' }}">
                                <label class="block text-xs font-bold text-slate-600 mb-1">Link Meeting Online *</label>
                                <input type="url" name="link_meet" id="edit-input-link"
                                       value="{{ $pendaftaran->jadwal?->link_meet }}"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 bg-slate-50">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2">Pilih Instruktur/Pemateri *</label>
                            <div class="grid md:grid-cols-2 gap-2 max-h-48 overflow-y-auto pr-1">
                                @foreach($pemateris as $pemateri)
                                    <label class="flex items-center gap-2 text-xs cursor-pointer p-2.5 bg-slate-50 hover:bg-slate-100 rounded-xl border border-slate-200/60 transition has-[:checked]:bg-cyan-50 has-[:checked]:border-cyan-200">
                                        <input type="checkbox" name="pemateri_ids[]" value="{{ $pemateri->id_pemateri }}"
                                               {{ in_array($pemateri->id_pemateri, $pendaftaran->jadwal?->pemateri->pluck('id_pemateri')->toArray() ?? []) ? 'checked' : '' }}
                                               class="w-3.5 h-3.5 text-cyan-600 rounded">
                                        <span class="font-semibold text-slate-700">{{ $pemateri->nama_lengkap }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex gap-3 pt-2">
                            <button type="submit" class="flex-1 bg-cyan-600 hover:bg-cyan-700 text-white font-bold text-xs px-5 py-3.5 rounded-xl transition uppercase tracking-wider">
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
                        <h3 class="text-base font-black text-slate-900">Tagihan Pelatihan Dikirim</h3>
                    </div>
                </div>
                <p class="text-sm text-slate-600 leading-relaxed mb-5">
                    Invoice tagihan final telah dikirimkan ke email PIC perusahaan. Menunggu perwakilan perusahaan mengunggah bukti transfer bank.
                </p>
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <span class="text-xs text-slate-400 font-bold uppercase block mb-1">Total Tagihan Final</span>
                            <span class="text-2xl font-black text-slate-900">Rp {{ number_format($pendaftaran->jadwal?->harga ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-slate-400 font-bold uppercase block mb-1">Status Pembayaran</span>
                            <span class="inline-block bg-red-100 text-red-700 text-xs font-black px-3 py-1.5 rounded-xl border border-red-200 uppercase tracking-wider">
                                Belum Bayar
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
                    Klien perusahaan telah mengunggah bukti transfer. Harap periksa detail bukti transfer di bawah sebelum menandai transaksi ini lunas.
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
                    <span class="text-xs text-slate-400 font-bold uppercase block mb-1">Nominal Tagihan Yang Harus Dibayar</span>
                    <span class="text-xl font-black text-slate-900">Rp {{ number_format($pendaftaran->jadwal?->harga ?? 0, 0, ',', '.') }}</span>
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('subadmin.pelatihan-kustom.confirm-payment', $pendaftaran->id_pendaftaran) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Konfirmasi bahwa bukti transfer valid dan pembayaran lunas? Status pelatihan akan berubah menjadi selesai.')"
                                class="w-full bg-[#1E6B3D] hover:bg-[#24824A] text-white font-black text-xs px-6 py-4 rounded-2xl shadow-lg shadow-emerald-700/10 transition uppercase tracking-wider flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Verifikasi Lunas & Selesaikan
                        </button>
                    </form>
                    <form action="{{ route('subadmin.pelatihan-kustom.reject-payment', $pendaftaran->id_pendaftaran) }}" method="POST">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Tolak pendaftaran ini?')"
                                class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-bold text-xs px-6 py-4 rounded-2xl transition uppercase tracking-wider">
                            Batalkan
                        </button>
                    </form>
                </div>
            @endif

            {{-- STAGE: SELESAI --}}
            @if($pendaftaran->status_progres === 'selesai')
                <div class="p-8 bg-gradient-to-br from-emerald-50 to-green-50 border border-emerald-200 rounded-2xl text-center space-y-4">
                    <span class="text-5xl block">🏆</span>
                    <h4 class="text-base font-black text-emerald-800 uppercase tracking-wider">Pelatihan Selesai & Lunas</h4>
                    <p class="text-sm text-emerald-700 max-w-sm mx-auto leading-relaxed">
                        Proses pelaksanaan pelatihan kustom B2B dan administrasi penagihan pembayaran telah selesai dengan sukses.
                    </p>
                    <div class="pt-2 border-t border-emerald-200/60">
                        <span class="text-xs text-emerald-600 font-semibold">Total Biaya Pelatihan: </span>
                        <span class="text-sm font-black text-emerald-800">Rp {{ number_format($pendaftaran->jadwal?->harga ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endif

            {{-- STAGE: DIBATALKAN --}}
            @if($pendaftaran->status_progres === 'dibatalkan')
                <div class="p-8 bg-rose-50 border border-rose-200 rounded-2xl text-center space-y-3">
                    <span class="text-5xl block">❌</span>
                    <h4 class="text-base font-black text-rose-800 uppercase tracking-wider">Pelatihan Dibatalkan</h4>
                    <p class="text-sm text-rose-700 max-w-sm mx-auto leading-relaxed">
                        Pelatihan kustom ini telah dibatalkan dari sistem.
                    </p>
                </div>
            @endif



        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- RIGHT / SIDEBAR COLUMN                                         --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <div class="space-y-6">

        {{-- ── DAFTAR PESERTA CARD IN SIDEBAR ─────────────────────── --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm">
            <div class="flex justify-between items-center mb-5 pb-3 border-b border-slate-100">
                <div>
                    <h3 class="text-sm font-black text-slate-900 tracking-tight flex items-center gap-2">
                        👥 Daftar Peserta B2B
                    </h3>
                    <span class="text-[10px] text-slate-400 font-bold uppercase mt-1">Total: {{ $participants->count() + 1 }} Orang</span>
                </div>
                @if(!in_array($pendaftaran->status_progres, ['selesai', 'dibatalkan']))
                    <div class="flex gap-2">
                        <button type="button" onclick="document.getElementById('modal-tambah-peserta').classList.remove('hidden')" 
                                title="Tambah Manual"
                                class="bg-[#1E6B3D] hover:bg-[#24824A] text-white p-2.5 rounded-xl transition text-xs flex items-center justify-center">
                            ➕
                        </button>
                        <button type="button" onclick="document.getElementById('modal-import-peserta').classList.remove('hidden')" 
                                title="Import CSV"
                                class="bg-cyan-600 hover:bg-cyan-700 text-white p-2.5 rounded-xl transition text-xs flex items-center justify-center">
                            📥
                        </button>
                    </div>
                @endif
            </div>

            <div class="space-y-4 max-h-[400px] overflow-y-auto pr-1">
                <!-- PIC Utama -->
                <div class="flex items-start justify-between gap-3 p-3 bg-cyan-50/50 border border-cyan-100 rounded-2xl">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-cyan-600 text-white flex items-center justify-center font-bold text-xs uppercase shrink-0">
                            {{ substr($pendaftaran->user?->nama ?? 'P', 0, 2) }}
                        </div>
                        <div>
                            <div class="text-xs font-black text-slate-900 leading-snug">{{ $pendaftaran->user?->nama }}</div>
                            <div class="text-[10px] text-slate-500 font-medium leading-normal">{{ $pendaftaran->user?->email }}</div>
                            <div class="text-[10px] text-slate-500 font-semibold mt-0.5 leading-normal">WA: {{ $pendaftaran->user?->no_telp }}</div>
                        </div>
                    </div>
                    <span class="bg-cyan-100 text-cyan-800 text-[8px] font-black uppercase tracking-wider px-2 py-0.5 rounded-md border border-cyan-200 shrink-0">
                        PIC
                    </span>
                </div>

                <!-- Peserta Utusan -->
                @forelse($participants as $part)
                    <div class="flex items-start justify-between gap-3 p-3 bg-slate-50 border border-slate-100 rounded-2xl hover:bg-slate-100/50 transition">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                {{ substr($part->user?->nama ?? 'U', 0, 2) }}
                            </div>
                            <div>
                                <div class="text-xs font-bold text-slate-800 leading-snug">{{ $part->user?->nama }}</div>
                                <div class="text-[10px] text-slate-500 font-medium leading-normal">{{ $part->user?->email }}</div>
                                <div class="text-[10px] text-slate-500 font-semibold mt-0.5 leading-normal">WA: {{ $part->user?->no_telp }}</div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-1.5 shrink-0">
                            <span class="bg-slate-100 text-slate-500 text-[8px] font-bold uppercase tracking-wider px-1.5 py-0.5 rounded-md border border-slate-200">
                                Utusan
                            </span>
                            @if(!in_array($pendaftaran->status_progres, ['selesai', 'dibatalkan']))
                                <form action="{{ route('subadmin.pelatihan-kustom.remove-participant', $part->id_pendaftaran) }}" method="POST" onsubmit="return confirm('Hapus peserta ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[10px] text-red-500 hover:text-red-700 font-bold transition">
                                        ❌ Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-[11px] text-slate-400 font-medium">Belum ada peserta utusan tambahan.</div>
                @endforelse
            </div>
        </div>

        {{-- Profil Perusahaan --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm">
            <h3 class="text-sm font-black text-slate-900 tracking-tight mb-5 flex items-center gap-2">
                <svg class="w-4 h-4 text-cyan-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
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
                <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
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
                        <svg class="w-3.5 h-3.5 fill-[#25D366]" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.938 3.659 1.435 5.63 1.435h.008c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                    <a href="mailto:{{ $pendaftaran->user?->email }}"
                       class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-3 py-2.5 rounded-xl flex items-center justify-center gap-1.5 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Email
                    </a>
                </div>
            </div>
        </div>

        {{-- Pengajuan Awal --}}
        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm">
            <h3 class="text-sm font-black text-slate-900 tracking-tight mb-5">
                🗒️ Catatan Pengajuan Awal
            </h3>
            <div class="space-y-3 text-xs">
                <div>
                    <span class="text-slate-400 font-bold block mb-0.5">Topik Pelatihan:</span>
                    <span class="font-bold text-slate-800">{{ $pendaftaran->jadwal?->jenis?->nama ?? '—' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 font-bold block mb-0.5">Harapan Tanggal:</span>
                    <span class="font-bold text-slate-800">
                        {{ $pendaftaran->rencana_tanggal_mulai ? $pendaftaran->rencana_tanggal_mulai->format('d M Y') : '—' }}
                        @if($pendaftaran->rencana_tanggal_selesai && $pendaftaran->rencana_tanggal_selesai != $pendaftaran->rencana_tanggal_mulai)
                            s/d {{ $pendaftaran->rencana_tanggal_selesai->format('d M Y') }}
                        @endif
                    </span>
                </div>
                <div>
                    <span class="text-slate-400 font-bold block mb-0.5">Pesan PIC:</span>
                    <p class="text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100 leading-relaxed font-semibold">{{ $pendaftaran->catatan_klien ?: 'Tidak ada pesan tambahan.' }}</p>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Modal Import Peserta -->
<div id="modal-import-peserta" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[2rem] border border-slate-100 max-w-md w-full p-8 shadow-2xl space-y-6">
        <div>
            <h3 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2">
                📥 Import Daftar Peserta
            </h3>
            <p class="text-xs text-slate-500 mt-1">Unggah berkas CSV untuk mendaftarkan seluruh karyawan peserta pelatihan kustom B2B sekaligus.</p>
        </div>
        
        <form action="{{ route('subadmin.pelatihan-kustom.import-participants', $pendaftaran->id_pendaftaran) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            
            <div class="border-2 border-dashed border-slate-200 hover:border-cyan-500 rounded-2xl p-6 text-center cursor-pointer relative transition bg-slate-50">
                <input type="file" name="csv_file" required accept=".csv"
                       class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"
                       onchange="updateFileName(this)">
                <div class="space-y-2">
                    <span class="text-3xl block">📄</span>
                    <span id="file-label" class="text-xs font-bold text-slate-600 block">Pilih Berkas CSV (.csv)</span>
                    <span class="text-[10px] text-slate-400 block">Maksimal ukuran berkas 5MB</span>
                </div>
            </div>

            <div class="bg-cyan-50 border border-cyan-100 rounded-2xl p-4 space-y-2">
                <p class="text-[11px] text-cyan-800 font-bold uppercase tracking-wider">Format Kolom CSV:</p>
                <code class="text-[10px] text-cyan-700 block bg-white px-3 py-2 rounded-xl border border-cyan-100 font-mono text-center">
                    nama,email,whatsapp
                </code>
                <p class="text-[10px] text-cyan-600 leading-relaxed font-semibold">
                    Pastikan CSV menggunakan separator koma (,) atau titik koma (;) dan baris pertama berisi header kolom di atas.
                </p>
            </div>
            
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-[#1E6B3D] hover:bg-[#24824A] text-white font-black text-xs px-6 py-4 rounded-xl shadow-lg shadow-emerald-700/10 transition uppercase tracking-wider">
                    Unggah & Import
                </button>
                <button type="button" onclick="document.getElementById('modal-import-peserta').classList.add('hidden')"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs px-5 py-4 rounded-xl transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Peserta -->
<div id="modal-tambah-peserta" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[2rem] border border-slate-100 max-w-md w-full p-8 shadow-2xl space-y-6">
        <div>
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Tambah Peserta Utusan</h3>
            <p class="text-xs text-slate-500 mt-1">Masukkan data karyawan yang akan diikutsertakan dalam pelatihan ini.</p>
        </div>
        
        <form action="{{ route('subadmin.pelatihan-kustom.add-participant', $pendaftaran->id_pendaftaran) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap *</label>
                <input type="text" name="nama" required placeholder="Nama Lengkap Karyawan"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 text-slate-700 font-semibold bg-slate-50">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Email Karyawan *</label>
                <input type="email" name="email" required placeholder="karyawan@email.com"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 text-slate-700 font-semibold bg-slate-50">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor WhatsApp/HP *</label>
                <input type="text" name="whatsapp" required placeholder="08xxxxxxxxxx"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-4 focus:ring-cyan-500/10 focus:outline-none focus:border-cyan-600 text-slate-700 font-semibold bg-slate-50">
            </div>
            
            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-[#1E6B3D] hover:bg-[#24824A] text-white font-black text-xs px-6 py-4 rounded-xl shadow-lg shadow-emerald-700/10 transition uppercase tracking-wider">
                    Simpan Peserta
                </button>
                <button type="button" onclick="document.getElementById('modal-tambah-peserta').classList.add('hidden')"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs px-5 py-4 rounded-xl transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function updateFileName(input) {
        const label = document.getElementById('file-label');
        if (input.files && input.files[0]) {
            label.innerText = input.files[0].name;
            label.classList.add('text-cyan-700');
        } else {
            label.innerText = 'Pilih Berkas CSV (.csv)';
            label.classList.remove('text-cyan-700');
        }
    }

    function formatHarga(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        let formatted = value ? 'Rp ' + parseInt(value, 10).toLocaleString('id-ID') : '';
        input.value = formatted;
        document.getElementById('harga-value').value = value;
    }

    function toggleFormLokasi(mode) {
        const linkContainer = document.getElementById('link-meet-container');
        const lokasiContainer = document.getElementById('lokasi-container');
        const inputLink = document.getElementById('input-link-meet');
        const inputLokasi = document.getElementById('input-lokasi');

        if (mode === 'offline') {
            lokasiContainer.classList.remove('hidden');
            inputLokasi.setAttribute('required', 'required');
            linkContainer.classList.add('hidden');
            inputLink.removeAttribute('required');
        } else if (mode === 'online') {
            linkContainer.classList.remove('hidden');
            inputLink.setAttribute('required', 'required');
            lokasiContainer.classList.add('hidden');
            inputLokasi.removeAttribute('required');
        } else { // hybrid
            linkContainer.classList.remove('hidden');
            inputLink.setAttribute('required', 'required');
            lokasiContainer.classList.remove('hidden');
            inputLokasi.setAttribute('required', 'required');
        }
    }

    function toggleEditLokasi(mode) {
        const linkContainer = document.getElementById('edit-link-container');
        const lokasiContainer = document.getElementById('edit-lokasi-container');
        const inputLink = document.getElementById('edit-input-link');
        const inputLokasi = document.getElementById('edit-input-lokasi');

        if (mode === 'offline') {
            lokasiContainer.classList.remove('hidden');
            inputLokasi.setAttribute('required', 'required');
            linkContainer.classList.add('hidden');
            inputLink.removeAttribute('required');
        } else if (mode === 'online') {
            linkContainer.classList.remove('hidden');
            inputLink.setAttribute('required', 'required');
            lokasiContainer.classList.add('hidden');
            inputLokasi.removeAttribute('required');
        } else { // hybrid
            linkContainer.classList.remove('hidden');
            inputLink.setAttribute('required', 'required');
            lokasiContainer.classList.remove('hidden');
            inputLokasi.setAttribute('required', 'required');
        }
    }

    function toggleEditJadwal() {
        const form = document.getElementById('edit-jadwal-form');
        form.classList.toggle('hidden');
        if (!form.classList.contains('hidden')) {
            form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
</script>
@endpush
