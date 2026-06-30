@extends('layouts.admin')
@section('title', 'Manajemen Layanan')
@section('page-title', 'Manajemen Layanan')
@section('page-subtitle', 'Kelola semua program layanan (Pelatihan, Konsultasi, Audit)')

@section('content')

<div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
    <div class="flex items-center gap-3 w-full md:w-auto">
        <form action="{{ route('admin.pelatihan.index') }}" method="GET" class="flex flex-1 md:w-64 bg-white border border-slate-200 rounded-2xl overflow-hidden focus-within:border-cyan-500 focus-within:ring-2 focus-within:ring-cyan-500/20 transition-all shadow-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari layanan..."
                   class="w-full bg-transparent border-none text-sm px-4 py-2 focus:ring-0 text-slate-700 placeholder-slate-400 font-medium">
            <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 flex items-center justify-center transition">
                <i class="fi fi-rr-search mt-0.5"></i>
            </button>
        </form>
        @if(request()->hasAny(['search']))
            <a href="{{ route('admin.pelatihan.index') }}" class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-600 hover:bg-red-100 border border-red-100 rounded-2xl transition tooltip-trigger" title="Reset Filter">
                <i class="fi fi-rr-cross"></i>
            </a>
        @endif
    </div>
    <a href="{{ route('admin.pelatihan.create') }}"
       class="bg-slate-900 text-white px-6 py-3 rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center gap-2 text-sm font-black group">
        <i class="fi fi-rr-plus text-cyan-400 group-hover:rotate-90 transition-transform duration-300"></i>
        Tambah Layanan Baru
    </a>
</div>

<div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">
                <tr>
                    <th class="px-5 py-4">Kategori Layanan</th>
                    <th class="px-5 py-4">Nama Layanan</th>
                    <th class="px-5 py-4">Materi</th>
                    <th class="px-5 py-4 min-w-[240px]">Pemateri</th>
                    <th class="px-5 py-4 text-center">Mode</th>
                    <th class="px-5 py-4">Rentang Waktu</th>
                    <th class="px-5 py-4">Biaya Investasi</th>
                    <th class="px-5 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($layanans as $l)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="p-5">
                        <div class="flex flex-col">
                            <span class="text-[12px] font-medium text-slate-900">{{ $l->kategori?->nama ?? 'Tanpa Kategori' }}</span>
                        </div>
                    </td>
                    <td class="p-5">
                        <div class="flex flex-col">
                            <span class="text-[12px] font-medium text-slate-900">{{ $l->nama }}</span>                            
                        </div>
                    </td>
                    <td class="p-5">
                        <p class="text-[12px] text-slate-900 font-medium leading-relaxed max-w-[200px] truncate">{{ $l->materi }}</p>
                    </td>
                    <td class="p-5 min-w-[240px]">
                        <div class="flex flex-col gap-1">
                            @foreach($l->pemateri as $p)
                                <div class="flex items-center gap-1.5 text-[12px] font-medium text-slate-900">
                                    <span>{{ $loop->iteration }}.</span>
                                    <span>{{ $p->nama_lengkap }}</span>
                                </div>
                            @endforeach
                        </div>
                    </td>
                    <td class="p-5 text-center">
                        <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $l->jenis_pertemuan === 'online' ? 'bg-cyan-50 text-cyan-600 border border-cyan-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                            {{ $l->jenis_pertemuan }}
                        </span>
                    </td>
                    <td class="p-5">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2 text-[12px] font-medium text-slate-900">
                                <i class="fi fi-rr-calendar text-indigo-400"></i>
                                {{ $l->tgl_mulai ? $l->tgl_mulai->format('d/m/Y') : '-' }}
                            </div>
                            <div class="flex items-center gap-2 text-[11px] font-medium text-slate-400">
                                <span class="w-3.5 h-px bg-slate-200"></span>
                                {{ $l->tgl_selesai ? $l->tgl_selesai->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                    </td>
                    <td class="p-5">
                        <span class="text-[12px] font-medium text-slate-900">IDR {{ number_format($l->harga, 0, ',', '.') }}</span>
                    </td>
                    <td class="p-5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.pelatihan.edit', $l->id_layanan) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg bg-cyan-50 text-cyan-600 hover:text-cyan-800 hover:bg-cyan-100 transition" title="Edit">
                                <i class="fi fi-rr-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.pelatihan.destroy', $l->id_layanan) }}" class="delete-form" data-name="{{ $l->nama }}">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-500 hover:text-rose-700 hover:bg-rose-100 transition" title="Hapus">
                                    <i class="fi fi-rr-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="p-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-3xl flex items-center justify-center mb-4">
                                <i class="fi fi-rr-bulb"></i>
                            </div>
                            <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Belum ada program layanan</p>
                            <a href="{{ route('admin.pelatihan.create') }}" class="mt-4 text-xs font-bold text-indigo-600 hover:underline">Tambah Layanan Pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($layanans->hasPages())
    <div class="p-6 border-t border-slate-100">
        {{ $layanans->appends(request()->query())->links('vendor.pagination.tailwind') }}
    </div>
    @endif
</div>

@endsection
