@extends('layouts.subadmin')
@section('title', 'Edit Materi')
@section('page-title', 'Edit Materi Pelatihan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('subadmin.materi.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-xs uppercase tracking-widest transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-7 py-6 border-b border-slate-100 bg-slate-50/30">
            <h2 class="text-xl font-black text-slate-900">Form Edit Materi</h2>
        </div>

        <form method="POST" action="{{ route('subadmin.materi.update', $materi->id_materi) }}" enctype="multipart/form-data" class="p-7 space-y-7">
            @csrf
            @method('PUT')

            @if($errors->any())
                <div class="bg-red-50 text-red-700 p-4 rounded-xl text-sm font-medium">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Judul Materi *</label>
                <input type="text" name="judul" value="{{ old('judul', $materi->judul) }}" required
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Deskripsi Singkat</label>
                <textarea name="deskripsi" rows="3"
                          class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">{{ old('deskripsi', $materi->deskripsi) }}</textarea>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Ganti File Materi (Wajib PDF, Max 10MB) - Opsional</label>
                @if($materi->file_path)
                <div class="mb-3 text-sm">
                    File saat ini: <a href="{{ Storage::url($materi->file_path) }}" target="_blank" class="text-indigo-600 font-bold underline">Lihat PDF</a>
                </div>
                @endif
                <input type="file" name="file_materi" accept=".pdf"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="text-xs text-slate-400 mt-2">Biarkan kosong jika tidak ingin mengubah file.</p>
            </div>

            <div class="flex gap-4 pt-4 border-t border-slate-100">
                <a href="{{ route('subadmin.materi.index') }}" class="px-6 py-3 text-sm font-black text-slate-400 hover:text-slate-600 transition">Batal</a>
                <button type="submit" class="flex-1 bg-slate-900 text-white py-3 rounded-xl text-sm font-black hover:bg-slate-800 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
