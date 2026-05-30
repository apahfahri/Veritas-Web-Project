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
        <svg class="w-5 h-5 text-cyan-400 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
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
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.rekening.destroy', $r->id_rekening) }}" class="delete-form" data-name="Rekening {{ $r->nama_bank }} - {{ $r->nomor_rekening }}">
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
                    <td colspan="5" class="p-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-3xl flex items-center justify-center mb-4">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
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
