@extends('layouts.app')
@section('title', 'Pelatihan K3 — PT Katiga Veritas Indonesia')
@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- HEADER -->
    <div class="relative overflow-hidden bg-gradient-to-r from-[#1E6B3D] via-[#24824A] to-[#3CDA7D] text-white py-12 shadow-sm">
        <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -left-10 -bottom-10 w-72 h-72 bg-[#3CDA7D]/20 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="flex items-center gap-4 mb-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white shadow-inner text-2xl">
                    <i class="fi fi-rr-shield-check"></i>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Pelatihan K3 Veritas</h1>
            </div>
            <p class="text-base md:text-lg text-emerald-50 max-w-2xl font-light">Pilih program pelatihan K3 unggulan bersertifikat nasional yang sesuai dengan kompetensi dan kebutuhan industri Anda.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- SEARCH + FILTER -->
        <form method="GET" action="{{ route('training.list') }}" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] mb-8 transition-all hover:shadow-[0_4px_25px_-2px_rgba(0,0,0,0.08)]">
            <div class="grid md:grid-cols-3 gap-4">
                <div class="md:col-span-2 relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm flex items-center"><i class="fi fi-rr-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari materi pelatihan K3..."
                           class="w-full border border-slate-200 rounded-xl pl-11 pr-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400">
                </div>
                <div class="relative">
                    <select name="jenis" onchange="this.form.submit()"
                            class="w-full appearance-none border border-slate-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all text-slate-700 cursor-pointer">
                        <option value="">Semua Mode Pertemuan</option>
                        <option value="online"  {{ request('jenis') == 'online'  ? 'selected' : '' }}>Online (Virtual/Zoom)</option>
                        <option value="offline" {{ request('jenis') == 'offline' ? 'selected' : '' }}>Offline (Tatap Muka)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>
        </form>

        <!-- REQUEST COMPANY TRAINING BANNER -->
        <div class="relative overflow-hidden bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-[0_8px_30px_-6px_rgba(245,158,11,0.3)] p-4 md:p-6 mb-8 text-white flex flex-col md:flex-row items-center justify-between transition-transform duration-300 hover:scale-[1.01]">
                        <div class="absolute -right-16 -bottom-16 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <div class="mb-4 md:mb-0 relative z-10 max-w-xl text-center md:text-left">
                                <h2 class="text-base md:text-lg font-bold mb-2 flex items-center justify-center md:justify-start gap-2">
                    <i class="fi fi-rr-building"></i> Butuh Pelatihan Khusus Perusahaan?
                </h2>
                <p class="text-sm md:text-base text-amber-50 font-light">Kami menyediakan program pelatihan <strong>In-House / Custom Training</strong> K3 khusus yang dirancang eksklusif untuk memenuhi regulasi dan operasional korporasi Anda.</p>
            </div>
            <a href="{{ route('request.training.create') }}" class="relative z-10 bg-white text-orange-600 font-bold px-5 py-3 rounded-xl hover:bg-orange-50 active:scale-95 transition-all whitespace-nowrap shadow-md hover:shadow-lg">
                Ajukan Request Pelatihan
            </a>
        </div>

        <!-- RESULT COUNT -->
        <div class="mb-6 text-sm text-slate-500">
            Menampilkan <strong class="text-slate-800 font-bold">{{ $jadwals->total() }}</strong> program pelatihan
        </div>

        @if($jadwals->isEmpty())
            <div class="text-center py-20 bg-white border border-slate-100 rounded-2xl shadow-sm">
                <i class="fi fi-rr-box-open text-5xl mb-4 text-slate-300 block"></i>
                <h3 class="text-lg font-bold text-slate-600">Tidak ada pelatihan ditemukan</h3>
                <a href="{{ route('training.list') }}" class="mt-4 inline-block text-[#1E6B3D] hover:underline text-sm font-medium">Reset filter pencarian</a>
            </div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($jadwals as $pelatihan)
                <div class="flex flex-col bg-white rounded-2xl border border-slate-100 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.03)] overflow-hidden group hover:shadow-[0_15px_35px_-8px_rgba(0,0,0,0.08)] hover:-translate-y-1 transition-all duration-300">
                    <!-- Premium Decorative Header -->
                    <div class="relative aspect-video overflow-hidden">
                        @if($pelatihan->foto)
                            <img src="{{ asset('storage/'.$pelatihan->foto) }}" alt="{{ $pelatihan->jenis?->nama ?? 'Pelatihan' }}" class="object-cover w-full h-full"/>
                        @else
                            <div class="bg-gradient-to-br from-emerald-800 via-[#1E6B3D] to-[#3CDA7D] flex items-center justify-center w-full h-full">
                                <i class="fi fi-rr-graduation-cap text-4xl text-white/70"></i>
                            </div>
                        @endif

                        <!-- Floating Status Badge -->
                        <div class="absolute top-3 right-3 z-10">
                            @if($pelatihan->status_pelaksanaan === 'Berlangsung')
                                <span class="bg-rose-500 text-white text-[10px] font-bold tracking-wider uppercase px-2.5 py-1.5 rounded-lg shadow-md flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                                    Berlangsung
                                </span>
                            @elseif($pelatihan->status_pelaksanaan === 'Akan Datang')
                                <span class="bg-sky-500 text-white text-[10px] font-bold tracking-wider uppercase px-2.5 py-1.5 rounded-lg shadow-md">
                                    Akan Datang
                                </span>
                            @else
                                <span class="bg-slate-600 text-white text-[10px] font-bold tracking-wider uppercase px-2.5 py-1.5 rounded-lg shadow-md">
                                    {{ $pelatihan->status_pelaksanaan }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <!-- BADGES -->
                            <div class="flex items-center justify-between mb-4">
                                <span class="bg-[#1E6B3D]/10 text-[#1E6B3D] text-[11px] font-bold tracking-wider uppercase px-2.5 py-1 rounded-lg">
                                    {{ $pelatihan->kategori?->nama ?? 'Pelatihan K3' }}
                                </span>
                                <span class="text-[11px] font-bold tracking-wider uppercase px-2.5 py-1 rounded-lg {{ $pelatihan->jenis_pertemuan === 'online' ? 'bg-sky-50 text-sky-600 border border-sky-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }} flex items-center gap-1">
                                    @if($pelatihan->jenis_pertemuan === 'online')
                                        <i class="fi fi-rr-globe"></i> Online
                                    @else
                                        <i class="fi fi-rr-building"></i> Offline
                                    @endif
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 line-clamp-1 group-hover:text-[#1E6B3D] transition-colors mb-2" title="{{ $pelatihan->jenis?->nama }}">
                                {{ $pelatihan->jenis?->nama }}
                            </h3>
                            
                            <div class="flex items-baseline gap-1.5 mb-3">
                                <span class="text-sm font-semibold text-slate-400">Rp</span>
                                <span class="text-2xl font-black text-slate-800 tracking-tight">
                                    {{ number_format($pelatihan->harga, 0, ',', '.') }}
                                </span>
                            </div>

                            <p class="text-xs text-slate-500 leading-relaxed mb-3 line-clamp-2">
                                {{ $pelatihan->deskripsi ?? 'Program kompetensi K3 standar nasional berkualitas tinggi untuk menjamin profesionalitas kerja Anda.' }}
                            </p>
                        </div>

                        <div>
                            <!-- METADATA GRID -->
                            <div class="border-t border-slate-50 pt-3 pb-3 space-y-2.5 text-xs text-slate-600">
                                @if($pelatihan->kapasitas)
                                <div class="flex items-center gap-2">
                                    <i class="fi fi-rr-users text-gray-400"></i>
                                    <span>Kapasitas: {{ $pelatihan->kapasitas }} peserta</span>
                                </div>
                                @endif
                            </div>

                            <a href="{{ route('training.detail', $pelatihan->id_jadwal) }}"
                               class="block w-full text-center bg-[#1E6B3D] text-white text-sm font-bold py-3 rounded-xl hover:bg-[#24824A] active:scale-[0.98] transition-all shadow-[0_4px_12px_-3px_rgba(30,107,61,0.2)] hover:shadow-[0_6px_20px_-3px_rgba(30,107,61,0.3)]">
                                Lihat Detail & Daftar
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-10">
                {{ $jadwals->links() }}
            </div>
        @endif
    </div>
</div>

@endsection