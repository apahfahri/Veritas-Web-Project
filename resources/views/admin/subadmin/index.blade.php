@extends('layouts.admin')
@section('title', 'Manajemen Subadmin')
@section('page-title', 'Manajemen Subadmin')
@section('page-subtitle', 'Kelola data dan hak akses staf operasional (Subadmin)')

@section('content')

<div class="flex flex-wrap justify-between items-end gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Akun Staf</h2>
        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">Total: {{ $admins->total() }} Staf Terdaftar</p>
    </div>
    <a href="{{ route('admin.subadmin.create') }}"
       class="bg-slate-900 text-white px-6 py-3 rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center gap-2 text-sm font-black group">
        <svg class="w-5 h-5 text-cyan-400 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Tambah Subadmin Baru
    </a>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50">Staf Detail</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50">Email / Kontak</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50">WhatsApp / Telp</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50 text-center">Status Akses</th>
                    <th class="p-6 text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($admins as $a)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="p-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm font-black shadow-sm">
                                {{ strtoupper(substr($a->username, 0, 1)) }}
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-900 group-hover:text-indigo-600 transition">{{ $a->username }}</span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID: #{{ $a->id_admin }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span class="text-xs font-bold text-slate-600">{{ $a->email }}</span>
                        </div>
                    </td>
                    <td class="p-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span class="text-xs font-bold text-slate-600">{{ $a->no_telp ?? '-' }}</span>
                        </div>
                    </td>
                    <td class="p-6 text-center">
                        <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $a->status === 'aktif' ? 'bg-teal-50 text-teal-600 border border-teal-100' : 'bg-red-50 text-red-600 border border-red-100' }}">
                            {{ $a->status }}
                        </span>
                    </td>
                    <td class="p-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.subadmin.edit', $a->id_admin) }}"
                               class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-indigo-600 hover:text-indigo-600 hover:shadow-lg hover:shadow-indigo-50 transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.subadmin.destroy', $a->id_admin) }}" class="delete-form" data-name="{{ $a->username }}">
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
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Belum ada staf terdaftar</p>
                            <a href="{{ route('admin.subadmin.create') }}" class="mt-4 text-xs font-bold text-indigo-600 hover:underline">Tambah Subadmin Pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($admins->hasPages())
    <div class="p-6 border-t border-slate-50 bg-slate-50/30">
        {{ $admins->links() }}
    </div>
    @endif
</div>

@endsection
