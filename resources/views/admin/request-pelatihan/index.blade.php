@extends('layouts.admin')
@section('title', 'Request Pelatihan Perusahaan')
@section('page-title', 'Request Pelatihan')
@section('page-subtitle', 'Daftar permintaan pelatihan dari perusahaan / instansi')

@section('content')

{{-- Alerts --}}
@if(session('success'))
<div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl text-sm font-medium">
    ✅ {{ session('success') }}
</div>
@endif

{{-- Header + Filter --}}
<div class="flex flex-wrap justify-between items-end gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Request Pelatihan</h2>
        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">Total: {{ $requests->total() }} Request Masuk</p>
    </div>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('admin.request-pelatihan.index') }}" class="flex flex-wrap gap-3 mb-6">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari perusahaan, topik, atau PIC..."
           class="border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800 w-72">
    <select name="status" class="border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-800">
        <option value="">Semua Status</option>
        <option value="pending"   {{ request('status') == 'pending'   ? 'selected' : '' }}>Pending</option>
        <option value="dihubungi" {{ request('status') == 'dihubungi' ? 'selected' : '' }}>Dihubungi</option>
        <option value="selesai"   {{ request('status') == 'selesai'   ? 'selected' : '' }}>Selesai</option>
        <option value="ditolak"   {{ request('status') == 'ditolak'   ? 'selected' : '' }}>Ditolak</option>
    </select>
    <button type="submit" class="bg-slate-900 text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-slate-700 transition">Filter</button>
    @if(request()->hasAny(['search','status']))
        <a href="{{ route('admin.request-pelatihan.index') }}" class="text-sm text-slate-500 hover:underline self-center">Reset</a>
    @endif
</form>

<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100/50 border-b-2 border-slate-100">
                    <th class="p-5 text-[12px] font-black text-slate-900">#</th>
                    <th class="p-5 text-[12px] font-black text-slate-900">Perusahaan / PIC</th>
                    <th class="p-5 text-[12px] font-black text-slate-900">Topik</th>
                    <th class="p-5 text-[12px] font-black text-slate-900">Tgl. Harapan</th>
                    <th class="p-5 text-[12px] font-black text-slate-900">Peserta</th>
                    <th class="p-5 text-[12px] font-black text-slate-900 text-center">Status</th>
                    <th class="p-5 text-[12px] font-black text-slate-900 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($requests as $req)
                @php
                    $statusColor = match($req->status) {
                        'pending'   => 'bg-yellow-50 text-yellow-600 border border-yellow-200',
                        'dihubungi' => 'bg-blue-50 text-blue-600 border border-blue-200',
                        'selesai'   => 'bg-emerald-50 text-emerald-600 border border-emerald-200',
                        'ditolak'   => 'bg-red-50 text-red-600 border border-red-200',
                        default     => 'bg-slate-100 text-slate-500',
                    };
                @endphp
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="p-5 text-[12px] text-slate-400 font-medium">{{ $req->id_request }}</td>
                    <td class="p-5">
                        <div class="font-bold text-slate-900 text-[13px]">{{ $req->nama_perusahaan }}</div>
                        <div class="text-[11px] text-slate-500">{{ $req->nama_lengkap }} — {{ $req->jabatan ?? '-' }}</div>
                        <div class="text-[11px] text-slate-400">{{ $req->email }} | {{ $req->no_telp }}</div>
                    </td>
                    <td class="p-5 text-[12px] text-slate-700 font-medium max-w-[180px]">{{ $req->topik_pelatihan }}</td>
                    <td class="p-5 text-[12px] text-slate-600 font-medium">
                        {{ $req->tanggal_harapan ? $req->tanggal_harapan->format('d M Y') : '—' }}
                    </td>
                    <td class="p-5 text-[12px] text-slate-600 font-medium text-center">{{ $req->jumlah_karyawan ?? '—' }}</td>
                    <td class="p-5 text-center">
                        <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $statusColor }}">
                            {{ ucfirst($req->status) }}
                        </span>
                    </td>
                    <td class="p-5 text-center">
                        <a href="{{ route('admin.request-pelatihan.show', $req->id_request) }}"
                           class="inline-flex items-center gap-1 px-4 py-2 rounded-xl bg-slate-900 text-white text-[11px] font-bold hover:bg-slate-700 transition">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-20 text-center">
                        <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Belum ada request masuk</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($requests->hasPages())
    <div class="p-6 border-t border-slate-50 bg-slate-50/30">
        {{ $requests->links() }}
    </div>
    @endif
</div>

@endsection
