@extends('layouts.admin')
@section('title', 'Manajemen Sertifikat')
@section('page-title', 'Manajemen Sertifikat')
@section('page-subtitle', 'Daftar sertifikat yang telah diterbitkan untuk klien')

@section('content')

<div class="flex flex-wrap justify-between items-end gap-6 mb-8">
    <div class="bg-white px-6 py-4 rounded-[24px] shadow-sm border border-slate-100 flex items-center gap-4">
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"></path></svg>
        </div>
        <div>
            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em]">Sertifikat Terbit</p>
            <h3 class="text-xl font-black text-slate-900 tracking-tight">{{ number_format($sertifikats->total()) }} <span class="text-slate-300 text-sm font-bold uppercase tracking-widest ml-1">Dokumen</span></h3>
        </div>
    </div>
    
    <a href="{{ route('admin.pendaftaran.index') }}?status=selesai" class="bg-slate-900 text-white px-8 py-4 rounded-2xl text-sm font-black hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center gap-3 group">
        <svg class="w-5 h-5 text-cyan-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Terbitkan Dokumen Baru
    </a>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50">No. Sertifikat</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50">Informasi Pemegang</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50">Program Layanan</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50 text-center">Tanggal Terbit</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($sertifikats as $s)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="p-6">
                        <span class="px-4 py-1.5 bg-slate-100 text-slate-600 rounded-xl font-mono font-black text-[10px] border border-slate-200/50 uppercase tracking-widest">{{ $s->no_sertifikat }}</span>
                    </td>
                    <td class="p-6">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-[10px] font-black">
                                {{ strtoupper(substr($s->nama_lengkap, 0, 1)) }}
                            </div>
                            <span class="text-sm font-black text-slate-900 group-hover:text-indigo-600 transition">{{ $s->nama_lengkap }}</span>
                        </div>
                    </td>
                    <td class="p-6">
                        <div class="text-xs font-bold text-slate-500 max-w-[250px] truncate leading-relaxed">{{ $s->pendaftaran?->layanan?->nama ?? '-' }}</div>
                    </td>
                    <td class="p-6 text-center whitespace-nowrap">
                        <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest">{{ $s->tanggal_terbit->format('d M Y') }}</span>
                    </td>
                    <td class="p-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('verification') }}" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-indigo-600 hover:text-indigo-600 hover:shadow-lg hover:shadow-indigo-50 transition shadow-sm" title="Verifikasi">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-24 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-3xl flex items-center justify-center mb-4">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"></path></svg>
                            </div>
                            <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Belum ada dokumen sertifikat</p>
                            <a href="{{ route('admin.pendaftaran.index') }}?status=selesai" class="mt-4 text-xs font-bold text-indigo-600 hover:underline">Terbitkan Dokumen Pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($sertifikats->hasPages())
    <div class="p-8 border-t border-slate-50 bg-slate-50/30">
        {{ $sertifikats->links() }}
    </div>
    @endif
</div>

@endsection
