@extends('layouts.admin')
@section('title', 'Manajemen Layanan')
@section('page-title', 'Manajemen Layanan')
@section('page-subtitle', 'Kelola semua program layanan (Pelatihan, Konsultasi, Audit)')

@section('content')

<div class="flex flex-wrap justify-between items-end gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Layanan</h2>
        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">Total: {{ $layanans->total() }} Program Tersedia</p>
    </div>
    <a href="{{ route('admin.pelatihan.create') }}"
       class="bg-slate-900 text-white px-6 py-3 rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center gap-2 text-sm font-black group">
        <i class="fi fi-rr-plus text-cyan-400 group-hover:rotate-90 transition-transform duration-300"></i>
        Tambah Layanan Baru
    </a>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100/50 border-b-2 border-slate-100">
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Kategori Layanan</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Nama Layanan</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Materi</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 min-w-[240px]">Pemateri</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Mode</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Rentang Waktu</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Biaya Investasi</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($layanans as $l)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="p-6">
                        <div class="flex flex-col">
                            <span class="text-[12px] font-medium text-slate-900">{{ $l->kategori?->nama ?? 'Tanpa Kategori' }}</span>
                        </div>
                    </td>
                    <td class="p-6">
                        <div class="flex flex-col">
                            <span class="text-[12px] font-medium text-slate-900">{{ $l->nama }}</span>                            
                        </div>
                    </td>
                    <td class="p-6">
                        <p class="text-[12px] text-slate-900 font-medium leading-relaxed max-w-[200px] truncate">{{ $l->materi }}</p>
                    </td>
                    <td class="p-6 min-w-[240px]">
                        <div class="flex flex-col gap-1">
                            @foreach($l->pemateri as $p)
                                <div class="flex items-center gap-1.5 text-[12px] font-medium text-slate-900">
                                    <span>{{ $loop->iteration }}.</span>
                                    <span>{{ $p->nama_lengkap }}</span>
                                </div>
                            @endforeach
                        </div>
                    </td>
                    <td class="p-6 text-center">
                        <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $l->jenis_pertemuan === 'online' ? 'bg-cyan-50 text-cyan-600 border border-cyan-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                            {{ $l->jenis_pertemuan }}
                        </span>
                    </td>
                    <td class="p-6">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2 text-[12px] font-medium text-slate-900">
                                <i class="fi fi-rr-calendar .5 .5 text-indigo-400"></i>
                                {{ $l->tgl_mulai ? $l->tgl_mulai->format('d/m/Y') : '-' }}
                            </div>
                            <div class="flex items-center gap-2 text-[11px] font-medium text-slate-400">
                                <span class="w-3.5 h-px bg-slate-200"></span>
                                {{ $l->tgl_selesai ? $l->tgl_selesai->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                    </td>
                    <td class="p-6">
                        <span class="text-[12px] font-medium text-slate-900">IDR {{ number_format($l->harga, 0, ',', '.') }}</span>
                    </td>
                    <td class="p-6">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.pelatihan.edit', $l->id_layanan) }}"
                               class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-indigo-600 hover:text-indigo-600 hover:shadow-lg hover:shadow-indigo-50 transition shadow-sm">
                                <i class="fi fi-rr-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.pelatihan.destroy', $l->id_layanan) }}" class="delete-form" data-name="{{ $l->nama }}">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-red-500 hover:text-red-500 hover:shadow-lg hover:shadow-red-50 transition shadow-sm">
                                    <i class="fi fi-rr-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-20 text-center">
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
    <div class="p-6 border-t border-slate-50 bg-slate-50/30">
        {{ $layanans->links() }}
    </div>
    @endif
</div>

@endsection
