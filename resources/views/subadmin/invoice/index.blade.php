@extends('layouts.subadmin')
@section('title', 'Kelola Invoice')
@section('page-title', 'Pengaturan Invoice & Rekening')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <form method="POST" action="{{ route('subadmin.invoice.update') }}" id="invoiceForm">
        @csrf
        @method('PUT')

        <!-- Toggle Rekening Aktif -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm mb-8">
            <h3 class="text-lg font-black text-slate-900 tracking-tight mb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                Pilih Rekening Aktif
            </h3>
            <p class="text-xs text-slate-500 mb-8">Hanya satu rekening yang bisa aktif pada satu waktu. Rekening aktif akan ditampilkan di invoice pelanggan.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Rekening 1 -->
                <div id="card-rek-1" class="relative p-6 rounded-2xl border-2 transition-all duration-300 cursor-pointer {{ $settings->rekening_1_aktif ? 'border-cyan-500 bg-cyan-50/30 shadow-lg shadow-cyan-100' : 'border-slate-200 bg-white hover:border-slate-300' }}" onclick="selectRekening(1)">
                    <input type="radio" name="rekening_aktif" value="1" {{ $settings->rekening_1_aktif ? 'checked' : '' }} class="hidden" id="rek_radio_1">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] font-black uppercase tracking-widest {{ $settings->rekening_1_aktif ? 'text-cyan-600' : 'text-slate-400' }}" id="label-rek-1">Rekening 1</span>
                        <div id="badge-rek-1" class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest transition {{ $settings->rekening_1_aktif ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">
                            {{ $settings->rekening_1_aktif ? '✓ Aktif' : 'Nonaktif' }}
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Nama Bank</label>
                            <input type="text" name="rekening_1_bank" value="{{ old('rekening_1_bank', $settings->rekening_1_bank) }}" required
                                   class="w-full bg-white border border-slate-200 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 outline-none transition">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Nomor Rekening</label>
                            <input type="text" name="rekening_1_nomor" value="{{ old('rekening_1_nomor', $settings->rekening_1_nomor) }}" required
                                   class="w-full bg-white border border-slate-200 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 outline-none transition">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Atas Nama</label>
                            <input type="text" name="rekening_1_atas_nama" value="{{ old('rekening_1_atas_nama', $settings->rekening_1_atas_nama) }}" required
                                   class="w-full bg-white border border-slate-200 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 outline-none transition">
                        </div>
                    </div>
                </div>

                <!-- Rekening 2 -->
                <div id="card-rek-2" class="relative p-6 rounded-2xl border-2 transition-all duration-300 cursor-pointer {{ $settings->rekening_2_aktif ? 'border-cyan-500 bg-cyan-50/30 shadow-lg shadow-cyan-100' : 'border-slate-200 bg-white hover:border-slate-300' }}" onclick="selectRekening(2)">
                    <input type="radio" name="rekening_aktif" value="2" {{ $settings->rekening_2_aktif ? 'checked' : '' }} class="hidden" id="rek_radio_2">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] font-black uppercase tracking-widest {{ $settings->rekening_2_aktif ? 'text-cyan-600' : 'text-slate-400' }}" id="label-rek-2">Rekening 2</span>
                        <div id="badge-rek-2" class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest transition {{ $settings->rekening_2_aktif ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-400' }}">
                            {{ $settings->rekening_2_aktif ? '✓ Aktif' : 'Nonaktif' }}
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Nama Bank</label>
                            <input type="text" name="rekening_2_bank" value="{{ old('rekening_2_bank', $settings->rekening_2_bank) }}" placeholder="Contoh: Bank BCA"
                                   class="w-full bg-white border border-slate-200 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 outline-none transition">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Nomor Rekening</label>
                            <input type="text" name="rekening_2_nomor" value="{{ old('rekening_2_nomor', $settings->rekening_2_nomor) }}" placeholder="Contoh: 123-456-789"
                                   class="w-full bg-white border border-slate-200 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 outline-none transition">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Atas Nama</label>
                            <input type="text" name="rekening_2_atas_nama" value="{{ old('rekening_2_atas_nama', $settings->rekening_2_atas_nama) }}" placeholder="Contoh: PT Katiga Veritas Indonesia"
                                   class="w-full bg-white border border-slate-200 px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 outline-none transition">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personalisasi Invoice -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm mb-8">
            <h3 class="text-lg font-black text-slate-900 tracking-tight mb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Catatan Tambahan Invoice
            </h3>
            <p class="text-xs text-slate-500 mb-6">Catatan ini akan ditampilkan di bagian bawah invoice yang dikirim ke pelanggan (opsional).</p>
            
            <textarea name="catatan_invoice" rows="4" placeholder="Contoh: Pembayaran paling lambat 3 hari setelah pendaftaran. Hubungi admin untuk info lebih lanjut."
                      class="w-full bg-slate-50 border border-slate-200 px-5 py-4 rounded-2xl text-sm font-medium text-slate-700 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition resize-none">{{ old('catatan_invoice', $settings->catatan_invoice) }}</textarea>
        </div>

        <!-- Submit -->
        <div class="flex justify-end gap-4">
            <button type="submit" id="submitBtn" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-black text-sm px-8 py-4 rounded-2xl shadow-lg shadow-cyan-200 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span id="submitBtnText">Simpan Pengaturan</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function selectRekening(num) {
        const otherNum = num === 1 ? 2 : 1;
        
        // Set radio
        document.getElementById('rek_radio_' + num).checked = true;
        
        // Active card
        const activeCard = document.getElementById('card-rek-' + num);
        activeCard.classList.remove('border-slate-200', 'bg-white', 'hover:border-slate-300');
        activeCard.classList.add('border-cyan-500', 'bg-cyan-50/30', 'shadow-lg', 'shadow-cyan-100');
        
        const activeLabel = document.getElementById('label-rek-' + num);
        activeLabel.classList.remove('text-slate-400');
        activeLabel.classList.add('text-cyan-600');
        
        const activeBadge = document.getElementById('badge-rek-' + num);
        activeBadge.classList.remove('bg-slate-100', 'text-slate-400');
        activeBadge.classList.add('bg-emerald-100', 'text-emerald-600');
        activeBadge.textContent = '✓ Aktif';
        
        // Inactive card
        const inactiveCard = document.getElementById('card-rek-' + otherNum);
        inactiveCard.classList.remove('border-cyan-500', 'bg-cyan-50/30', 'shadow-lg', 'shadow-cyan-100');
        inactiveCard.classList.add('border-slate-200', 'bg-white', 'hover:border-slate-300');
        
        const inactiveLabel = document.getElementById('label-rek-' + otherNum);
        inactiveLabel.classList.remove('text-cyan-600');
        inactiveLabel.classList.add('text-slate-400');
        
        const inactiveBadge = document.getElementById('badge-rek-' + otherNum);
        inactiveBadge.classList.remove('bg-emerald-100', 'text-emerald-600');
        inactiveBadge.classList.add('bg-slate-100', 'text-slate-400');
        inactiveBadge.textContent = 'Nonaktif';
    }

    document.getElementById('invoiceForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        const btnText = document.getElementById('submitBtnText');
        btn.disabled = true;
        btn.classList.add('opacity-70', 'cursor-not-allowed');
        btnText.innerHTML = '<svg class="w-4 h-4 animate-spin inline mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...';
    });
</script>
@endpush
