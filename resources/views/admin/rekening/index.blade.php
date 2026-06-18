@extends('layouts.admin')
@section('title', 'Manajemen Rekening Pembayaran')
@section('page-title', 'Manajemen Rekening')
@section('page-subtitle', 'Kelola rekening bank resmi yang digunakan sistem untuk transaksi pelanggan')

@section('content')

<div class="flex flex-wrap justify-between items-end gap-4 mb-8 select-none">
    <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Rekening</h2>
        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">Total: {{ $rekenings->total() }} Rekening Terdaftar</p>
    </div>
    <a href="{{ route('admin.rekening.create') }}"
       class="bg-slate-900 text-white px-6 py-3 rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center gap-2 text-sm font-black group">
        <i class="fi fi-rr-plus text-cyan-400 group-hover:rotate-90 transition-transform duration-300"></i>
        Tambah Rekening Baru
    </a>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden select-none">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100/50 border-b-2 border-slate-100">
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Nama Bank</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Nomor Rekening</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Atas Nama</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Status Aktif</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($rekenings as $r)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="p-6">
                        <span class="text-sm font-black text-slate-800 tracking-tight block uppercase">{{ $r->nama_bank }}</span>
                    </td>
                    <td class="p-6">
                        <span class="text-sm font-mono font-bold text-slate-900">{{ $r->nomor_rekening }}</span>
                    </td>
                    <td class="p-6">
                        <span class="text-sm font-bold text-slate-700">{{ $r->atas_nama }}</span>
                    </td>
                    <td class="p-6">
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
                    <td class="p-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.rekening.edit', $r->id_rekening) }}"
                               class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-indigo-600 hover:text-indigo-600 hover:shadow-lg hover:shadow-indigo-50 transition shadow-sm">
                                <i class="fi fi-rr-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.rekening.destroy', $r->id_rekening) }}" class="delete-form" data-name="Rekening {{ $r->nama_bank }} - {{ $r->nomor_rekening }}">
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
    <div class="p-6 border-t border-slate-50 bg-slate-50/30">
        {{ $rekenings->links() }}
    </div>
    @endif
</div>

@endsection
