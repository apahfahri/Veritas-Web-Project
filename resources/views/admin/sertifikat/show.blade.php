@extends('layouts.admin')
@section('title', 'Detail Sertifikat')
@section('page-title', 'Detail Sertifikat')
@section('page-subtitle', 'Informasi lengkap dokumen resmi yang telah diterbitkan')

@section('header-actions')
<div class="flex items-center gap-3">
    <a href="{{ route('admin.sertifikat.edit', $sertifikat->no_sertifikat) }}" class="bg-white text-slate-900 border border-slate-200 px-6 py-3.5 rounded-2xl text-[11px] font-black uppercase tracking-wider hover:bg-slate-50 transition shadow-sm flex items-center gap-2">
        <i class="fi fi-rr-edit text-amber-500"></i>
        Edit Data
    </a>
    <button onclick="window.print()" class="bg-slate-900 text-white px-6 py-3.5 rounded-2xl text-[11px] font-black uppercase tracking-wider hover:bg-slate-800 transition shadow-xl shadow-slate-200 flex items-center gap-2">
        <i class="fi fi-rr-database text-cyan-400"></i>
        Cetak PDF
    </button>
</div>
@endsection

@section('content')

<div class="max-w-6xl mx-auto space-y-8 print:p-0">
    <div class="print:hidden">
        <a href="{{ route('admin.sertifikat.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-xs uppercase tracking-widest transition">
            <i class="fi fi-rr-arrow-left"></i>
            Kembali ke Daftar
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- LEFT: PREVIEW (Visual) -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white p-2 rounded-[2.5rem] shadow-2xl shadow-slate-200 border border-slate-100 overflow-hidden group relative">
                <!-- Watermark / Design Background -->
                <div class="absolute inset-0 opacity-[0.03] pointer-events-none flex items-center justify-center">
                    <i class="fi fi-rr-bolt"></i>
                </div>
                
                <div class="border-4 border-double border-slate-100 rounded-[2.2rem] p-12 text-center relative z-10 min-h-[500px] flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="w-20 h-20 bg-slate-900 rounded-2xl mx-auto flex items-center justify-center text-cyan-400 shadow-xl mb-6">
                            <i class="fi fi-rr-diploma"></i>
                        </div>
                        <h4 class="text-[10px] font-black uppercase tracking-[0.5em] text-slate-400">Certificate of Completion</h4>
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight leading-tight">DIBERIKAN KEPADA</h1>
                        <div class="h-0.5 w-24 bg-gradient-to-r from-transparent via-slate-200 to-transparent mx-auto my-4"></div>
                        <h2 class="text-4xl font-black text-indigo-600 tracking-tight underline decoration-slate-200 underline-offset-8">{{ $sertifikat->nama_lengkap }}</h2>
                    </div>

                    <div class="space-y-2 py-8">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-relaxed">Atas keberhasilannya menyelesaikan program:</p>
                        <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">{{ $sertifikat->pendaftaran?->layanan?->nama }}</h3>
                    </div>

                    <div class="flex justify-between items-end border-t border-slate-50 pt-8 mt-8">
                        <div class="text-left">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Nomor Sertifikat</p>
                            <p class="text-xs font-mono font-black text-slate-900">{{ $sertifikat->no_sertifikat }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal Terbit</p>
                            <p class="text-xs font-black text-slate-900">{{ $sertifikat->tanggal_terbit->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <p class="text-center text-[10px] text-slate-400 font-bold uppercase tracking-widest animate-pulse print:hidden italic">
                * Tampilan di atas hanyalah preview sistem (Layout PDF sebenarnya mungkin berbeda)
            </p>
        </div>

        <!-- RIGHT: DETAILS (Technical) -->
        <div class="lg:col-span-5 space-y-6 print:hidden">
            <!-- Data Pemilik -->
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center shadow-sm">
                        <i class="fi fi-rr-user"></i>
                    </div>
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Informasi Peserta</h3>
                </div>
                
                <div class="space-y-5">
                    <div class="flex justify-between items-center py-3 border-b border-slate-50">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama User</span>
                        <span class="text-xs font-black text-slate-900">{{ $sertifikat->pendaftaran?->user?->nama }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-slate-50">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Email Terdaftar</span>
                        <span class="text-xs font-black text-slate-900">{{ $sertifikat->pendaftaran?->user?->email }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-slate-50">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pendaftaran ID</span>
                        <span class="text-xs font-black text-indigo-600">#{{ $sertifikat->id_pendaftaran }}</span>
                    </div>
                    @if($sertifikat->pendaftaran?->is_utusan_perusahaan)
                    <div class="flex justify-between items-center py-3 border-b border-slate-50">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Perusahaan</span>
                        <span class="text-xs font-black text-slate-900">{{ $sertifikat->pendaftaran?->perusahaan?->nama }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Metadata -->
            <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-200/50">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-white text-slate-400 rounded-xl flex items-center justify-center shadow-sm">
                        <i class="fi fi-rr-info"></i>
                    </div>
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Informasi Sistem</h3>
                </div>
                
                <div class="space-y-4">
                    <div class="p-4 bg-white rounded-2xl border border-slate-100 flex justify-between items-center">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Diterbitkan Pada</p>
                            <p class="text-[11px] font-black text-slate-700">{{ $sertifikat->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Terakhir Update</p>
                            <p class="text-[11px] font-black text-slate-700">{{ $sertifikat->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    @media print {
        body { background: white !important; }
        aside, header, footer, .print\:hidden { display: none !important; }
        .ml-72 { margin-left: 0 !important; }
        .p-8 { padding: 0 !important; }
        .bg-white { box-shadow: none !important; border: none !important; }
        .rounded-\[2\.5rem\] { border-radius: 0 !important; }
        .border-slate-100 { border-color: #f1f5f9 !important; }
    }
</style>

@endsection
