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
        <svg class="w-5 h-5 text-cyan-400 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Tambah Layanan Baru
    </a>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50">Kategori & Program</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50">Materi / Detail</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50 text-center">Mode</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50">Rentang Waktu</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50">Biaya Investasi</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($layanans as $l)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="p-6">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-indigo-500 uppercase tracking-tighter mb-1">{{ $l->kategori?->nama ?? 'TANPA KATEGORI' }}</span>
                            <span class="text-sm font-black text-slate-900 group-hover:text-indigo-600 transition">{{ $l->nama }}</span>
                            <div class="flex flex-wrap gap-1 mt-2">
                                @foreach($l->pemateri as $p)
                                    <span class="bg-slate-100 text-slate-500 px-2 py-0.5 rounded-lg text-[9px] font-bold uppercase tracking-tight">{{ $p->nama_lengkap }}</span>
                                @endforeach
                            </div>
                        </div>
                    </td>
                    <td class="p-6">
                        <p class="text-xs text-slate-500 font-bold leading-relaxed max-w-[200px] truncate">{{ $l->materi }}</p>
                    </td>
                    <td class="p-6 text-center">
                        <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $l->jenis_pertemuan === 'online' ? 'bg-cyan-50 text-cyan-600 border border-cyan-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                            {{ $l->jenis_pertemuan }}
                        </span>
                    </td>
                    <td class="p-6">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center gap-2 text-xs font-black text-slate-700">
                                <svg class="w-3.5 h-3.5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                                {{ $l->tgl_mulai ? $l->tgl_mulai->format('d/m/Y') : '-' }}
                            </div>
                            <div class="flex items-center gap-2 text-xs font-bold text-slate-400">
                                <span class="w-3.5 h-px bg-slate-200"></span>
                                {{ $l->tgl_selesai ? $l->tgl_selesai->format('d/m/Y') : '-' }}
                            </div>
                        </div>
                    </td>
                    <td class="p-6">
                        <span class="text-sm font-black text-slate-900">IDR {{ number_format($l->harga, 0, ',', '.') }}</span>
                    </td>
                    <td class="p-6">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.pelatihan.edit', $l->id_layanan) }}"
                               class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-indigo-600 hover:text-indigo-600 hover:shadow-lg hover:shadow-indigo-50 transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.pelatihan.destroy', $l->id_layanan) }}" class="delete-form" data-name="{{ $l->nama }}">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-red-500 hover:text-red-500 hover:shadow-lg hover:shadow-red-50 transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9l-.707.707M16.243 4.757l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
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
