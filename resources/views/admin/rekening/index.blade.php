@extends('layouts.admin')
@section('title', 'Manajemen Rekening Pembayaran')
@section('page-title', 'Manajemen Rekening')
@section('page-subtitle', 'Kelola rekening bank resmi yang digunakan sistem untuk transaksi pelanggan')

@section('content')

<div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden select-none">
    <div class="p-6 md:p-8 bg-slate-50/30 border-b border-slate-100 select-none">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <form method="GET" action="{{ route('admin.rekening.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto flex-1">
                <div class="relative flex-1 min-w-[200px] max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fi fi-rr-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari rekening..."
                           class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition">
                </div>
                <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fi fi-rr-search"></i> Cari Data
                </button>
                @if(request()->has('search'))
                    <a href="{{ route('admin.rekening.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-4 py-2.5 rounded-xl transition">Reset</a>
                @endif
            </form>

            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('admin.rekening.create') }}"
                   class="bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-md transition uppercase tracking-wider flex items-center gap-2">
                    <i class="fi fi-rr-plus"></i> Tambah Rekening Baru
                </a>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">
                <tr>
                    <th class="px-5 py-4">Nama Bank</th>
                    <th class="px-5 py-4">Nomor Rekening</th>
                    <th class="px-5 py-4">Atas Nama</th>
                    <th class="px-5 py-4 text-center">Status Aktif</th>
                    <th class="px-5 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($rekenings as $r)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="p-5">
                        <span class="text-sm font-black text-slate-800 tracking-tight block uppercase">{{ $r->nama_bank }}</span>
                    </td>
                    <td class="p-5">
                        <span class="text-sm font-mono font-bold text-slate-900">{{ $r->nomor_rekening }}</span>
                    </td>
                    <td class="p-5">
                        <span class="text-sm font-bold text-slate-700">{{ $r->atas_nama }}</span>
                    </td>
                    <td class="p-5">
                        <div class="flex items-center justify-center">
                            <form method="POST" action="{{ route('admin.rekening.toggle', $r->id_rekening) }}">
                                @csrf
                                <button type="submit" 
                                        title="{{ $r->status_aktif ? 'Nonaktifkan' : 'Aktifkan' }}"
                                        class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors duration-300 focus:outline-none {{ $r->status_aktif ? 'bg-emerald-500 shadow-[0_2px_8px_rgba(16,185,129,0.3)]' : 'bg-slate-200' }}">
                                    <span class="inline-block w-4 h-4 transform bg-white rounded-full transition-transform duration-300 {{ $r->status_aktif ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                </button>
                            </form>
                        </div>
                    </td>
                    <td class="p-5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.rekening.edit', $r->id_rekening) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg bg-cyan-50 text-cyan-600 hover:text-cyan-800 hover:bg-cyan-100 transition" title="Edit">
                                <i class="fi fi-rr-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.rekening.destroy', $r->id_rekening) }}" class="delete-form" data-name="Rekening {{ $r->nama_bank }} - {{ $r->nomor_rekening }}">
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
                    <td colspan="5" class="p-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-3xl flex items-center justify-center mb-4">
                                <i class="fi fi-rr-credit-card w-10 h-10"></i>
                            </div>
                            <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Belum ada rekening terdaftar</p>
                            <a href="{{ route('admin.rekening.create') }}" class="mt-4 text-xs font-bold text-indigo-600 hover:underline">Tambah Rekening Pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($rekenings->hasPages())
    <div class="p-6 border-t border-slate-100 flex justify-center">
        {{ $rekenings->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@endsection
