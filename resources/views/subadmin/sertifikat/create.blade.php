@extends('layouts.subadmin')

@section('title', 'Terbitkan Sertifikat')
@section('page-title', 'Terbitkan Sertifikat Baru')

@section('content')
<div class="bg-white rounded-[2rem] border border-slate-100 p-8 shadow-sm max-w-xl select-none">
    <h3 class="text-lg font-black text-slate-900 tracking-tight mb-6">Informasi Sertifikat</h3>

    @if($pendaftaranTersedia->isEmpty() && !$pendaftaran)
        <div class="p-6 bg-amber-50 border border-amber-200 text-amber-800 text-sm font-semibold rounded-2xl mb-6 leading-relaxed">
            ⚠️ Saat ini tidak ada peserta yang pelatihannya berstatus <strong>Selesai</strong> dan pembayarannya <strong>Lunas</strong> untuk diterbitkan sertifikatnya. Silakan selesaikan proses pendaftaran/pembayaran peserta terlebih dahulu.
        </div>
        <a href="{{ route('subadmin.sertifikat.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-6 py-3.5 rounded-xl transition inline-block">
            Kembali Ke Daftar
        </a>
    @else
        <form method="POST" action="{{ route('subadmin.sertifikat.store') }}">
            @csrf

            <div class="space-y-5">
                @if($pendaftaran)
                    <input type="hidden" name="pendaftaran_id" value="{{ $pendaftaran->id_pendaftaran }}">
                    <div>
                        <label class="text-xs font-extrabold text-slate-600 uppercase tracking-wider block mb-1">Peserta Pelatihan</label>
                        <input type="text" value="{{ $pendaftaran->nomor_pendaftaran }} - {{ $pendaftaran->user?->nama }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold outline-none text-slate-500" disabled>
                    </div>
                    <div>
                        <label class="text-xs font-extrabold text-slate-600 uppercase tracking-wider block mb-1">Layanan</label>
                        <input type="text" value="{{ $pendaftaran->jadwal?->jenis?->nama ?? ($pendaftaran->jadwal?->kategori?->nama ?? '—') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold outline-none text-slate-500" disabled>
                    </div>
                @else
                    <div>
                        <label class="text-xs font-extrabold text-slate-600 uppercase tracking-wider block mb-1">Pilih Peserta Pelatihan</label>
                        <select name="pendaftaran_id" id="pendaftaran_id" onchange="onParticipantChange()" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-cyan-500 font-semibold" required>
                            <option value="">-- Pilih Peserta --</option>
                            @foreach($pendaftaranTersedia as $p)
                                <option value="{{ $p->id_pendaftaran }}" data-nama="{{ $p->user?->nama }}" data-layanan="{{ $p->jadwal?->jenis?->nama ?? '—' }}">
                                    {{ $p->nomor_pendaftaran }} - {{ $p->user?->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-extrabold text-slate-600 uppercase tracking-wider block mb-1">Layanan</label>
                        <input type="text" id="layanan_display" value="—" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold outline-none text-slate-500" disabled>
                    </div>
                @endif

                <div>
                    <label class="text-xs font-extrabold text-slate-600 uppercase tracking-wider block mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap', $pendaftaran?->user?->nama ?? '') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-cyan-500 transition font-medium" placeholder="Nama Lengkap Pemegang Sertifikat" required>
                </div>

                <div>
                    <label class="text-xs font-extrabold text-slate-600 uppercase tracking-wider block mb-1">Tanggal Terbit</label>
                    <input type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit', date('Y-m-d')) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-cyan-500 transition font-medium" required>
                </div>

                <div class="pt-2 flex items-center gap-3">
                    <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-extrabold text-sm px-6 py-3.5 rounded-xl shadow-lg transition">
                        Terbitkan Sertifikat
                    </button>
                    <a href="{{ route('subadmin.sertifikat.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-6 py-3.5 rounded-xl transition">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function onParticipantChange() {
        const select = document.getElementById('pendaftaran_id');
        const selectedOption = select.options[select.selectedIndex];
        
        const namaInput = document.getElementById('nama_lengkap');
        const layananInput = document.getElementById('layanan_display');
        
        if (selectedOption && selectedOption.value !== "") {
            namaInput.value = selectedOption.getAttribute('data-nama') || '';
            layananInput.value = selectedOption.getAttribute('data-layanan') || '—';
        } else {
            namaInput.value = '';
            layananInput.value = '—';
        }
    }
</script>
@endpush
