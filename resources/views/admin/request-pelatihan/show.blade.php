@extends('layouts.admin')
@section('title', 'Detail Request Pelatihan #' . $item->id_request)
@section('page-title', 'Detail Request Pelatihan')
@section('page-subtitle', 'Informasi lengkap permintaan pelatihan dari perusahaan')

@section('content')

@if(session('success'))
<div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm font-medium">
    ✅ {{ session('success') }}
</div>
@endif

<div class="mb-6">
    <a href="{{ route('admin.request-pelatihan.index') }}" class="text-sm text-slate-500 hover:text-slate-800 transition">
        ← Kembali ke Daftar Request
    </a>
</div>

<div class="grid lg:grid-cols-3 gap-6">

    {{-- LEFT: Detail Request --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Data Perusahaan --}}
        <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm p-7">
            <h3 class="text-[13px] font-black text-slate-900 uppercase tracking-widest mb-5 border-b border-slate-100 pb-4">
                🏢 Data Perusahaan
            </h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-medium">Nama Perusahaan</dt>
                    <dd class="text-slate-900 font-bold text-right">{{ $item->nama_perusahaan }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-medium">Alamat</dt>
                    <dd class="text-slate-900 font-medium text-right max-w-[55%]">{{ $item->alamat_perusahaan }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-medium">Sektor Industri</dt>
                    <dd class="text-slate-900 font-medium">{{ $item->sektor_industri ?? '—' }}</dd>
                </div>
                @if($item->perusahaan)
                <div class="flex justify-between pt-2 border-t border-slate-100">
                    <dt class="text-slate-500 font-medium">ID Perusahaan (DB)</dt>
                    <dd class="text-blue-600 font-bold">
                        <a href="{{ route('admin.mitra.edit', $item->perusahaan->id_perusahaan) }}" class="hover:underline">
                            #{{ $item->perusahaan->id_perusahaan }} — Lihat Detail Perusahaan
                        </a>
                    </dd>
                </div>
                @endif
            </dl>
        </div>

        {{-- Data PIC --}}
        <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm p-7">
            <h3 class="text-[13px] font-black text-slate-900 uppercase tracking-widest mb-5 border-b border-slate-100 pb-4">
                👤 Data PIC / Penghubung
            </h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-medium">Nama Lengkap</dt>
                    <dd class="text-slate-900 font-bold">{{ $item->nama_lengkap }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-medium">Jabatan</dt>
                    <dd class="text-slate-900 font-medium">{{ $item->jabatan ?? '—' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-medium">Email</dt>
                    <dd class="text-blue-600 font-medium">
                        <a href="mailto:{{ $item->email }}" class="hover:underline">{{ $item->email }}</a>
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-medium">No. HP / WA</dt>
                    <dd class="text-slate-900 font-medium">{{ $item->no_telp }}</dd>
                </div>
            </dl>
        </div>

        {{-- Detail Request --}}
        <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm p-7">
            <h3 class="text-[13px] font-black text-slate-900 uppercase tracking-widest mb-5 border-b border-slate-100 pb-4">
                📋 Detail Request Pelatihan
            </h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-medium">Topik Pelatihan</dt>
                    <dd class="text-slate-900 font-bold">{{ $item->topik_pelatihan }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-medium">Estimasi Tanggal</dt>
                    <dd class="text-slate-900 font-medium">
                        {{ $item->tanggal_harapan ? $item->tanggal_harapan->format('d M Y') : '—' }}
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-medium">Jumlah Peserta</dt>
                    <dd class="text-slate-900 font-medium">{{ $item->jumlah_karyawan ? $item->jumlah_karyawan . ' orang' : '—' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-medium">Tanggal Submit</dt>
                    <dd class="text-slate-900 font-medium">{{ $item->created_at->format('d M Y, H:i') }}</dd>
                </div>
            </dl>
            @if($item->pesan_tambahan)
            <div class="mt-5 pt-5 border-t border-slate-100">
                <p class="text-[12px] font-black text-slate-500 uppercase tracking-widest mb-2">Pesan / Persyaratan Tambahan</p>
                <p class="text-sm text-slate-700 leading-relaxed bg-slate-50 rounded-xl p-4">{{ $item->pesan_tambahan }}</p>
            </div>
            @endif
        </div>

    </div>

    {{-- RIGHT: Update Status --}}
    <div class="space-y-6">
        <div class="bg-white rounded-[24px] border border-slate-100 shadow-sm p-7 sticky top-6">
            <h3 class="text-[13px] font-black text-slate-900 uppercase tracking-widest mb-5 border-b border-slate-100 pb-4">
                ⚙️ Update Status Request
            </h3>
            @php
                $statusColor = match($item->status) {
                    'pending'   => 'bg-yellow-50 text-yellow-600 border border-yellow-200',
                    'dihubungi' => 'bg-blue-50 text-blue-600 border border-blue-200',
                    'selesai'   => 'bg-emerald-50 text-emerald-600 border border-emerald-200',
                    'ditolak'   => 'bg-red-50 text-red-600 border border-red-200',
                    default     => 'bg-slate-100 text-slate-500',
                };
            @endphp
            <div class="mb-5 text-center">
                <span class="inline-flex px-4 py-2 rounded-full text-[11px] font-black uppercase tracking-widest {{ $statusColor }}">
                    Status Saat Ini: {{ ucfirst($item->status) }}
                </span>
            </div>
            <form method="POST" action="{{ route('admin.request-pelatihan.update-status', $item->id_request) }}">
                @csrf @method('PATCH')
                <label class="block text-sm font-medium text-slate-700 mb-2">Ubah Status</label>
                <select name="status" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800 mb-4">
                    <option value="pending"   {{ $item->status == 'pending'   ? 'selected' : '' }}>Pending</option>
                    <option value="dihubungi" {{ $item->status == 'dihubungi' ? 'selected' : '' }}>Dihubungi</option>
                    <option value="selesai"   {{ $item->status == 'selesai'   ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak"   {{ $item->status == 'ditolak'   ? 'selected' : '' }}>Ditolak</option>
                </select>
                <button type="submit" class="w-full bg-slate-900 text-white py-3 rounded-xl font-bold text-sm hover:bg-slate-700 transition">
                    Simpan Status
                </button>
            </form>

            <div class="mt-5 border-t border-slate-100 pt-5 space-y-2">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_telp) }}?text={{ rawurlencode('Halo '.$item->nama_lengkap.', kami dari Veritas ingin menindaklanjuti request pelatihan Anda mengenai '.$item->topik_pelatihan.'. Apakah Anda bisa dihubungi?') }}"
                   target="_blank"
                   class="flex items-center justify-center gap-2 w-full bg-emerald-500 hover:bg-emerald-600 text-white py-3 rounded-xl font-bold text-sm transition">
                    💬 Hubungi via WhatsApp
                </a>
                <a href="mailto:{{ $item->email }}"
                   class="flex items-center justify-center gap-2 w-full border border-slate-200 text-slate-700 py-3 rounded-xl font-bold text-sm hover:bg-slate-50 transition">
                    ✉️ Kirim Email
                </a>
            </div>
        </div>
    </div>

</div>

@endsection
