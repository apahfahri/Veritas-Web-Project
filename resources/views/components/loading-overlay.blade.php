<!-- ── CONFIRMATION MODAL ────────────────────────────────────────────── -->
<div id="confirm-modal" class="fixed inset-0 z-[9998] flex items-center justify-center bg-slate-950/60 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-6 border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.15)] transform transition-all duration-300 scale-90 opacity-0" id="confirm-content">
        <div class="flex flex-col items-center text-center">
            <!-- Icon -->
            <div class="w-16 h-16 mb-4 bg-emerald-50 text-[#1E6B3D] rounded-2xl flex items-center justify-center text-3xl shadow-inner border border-emerald-100 animate-pulse">
                🛡️
            </div>
            
            <h3 class="text-xl font-bold text-slate-800 mb-2 tracking-tight">Konfirmasi Pengiriman</h3>
            <p class="text-slate-500 text-sm leading-relaxed mb-6 px-4">
                Apakah Anda yakin semua data yang dimasukkan sudah benar? Tim kami akan segera memproses pengajuan Anda setelah terkirim.
            </p>
            
            <!-- Actions -->
            <div class="flex items-center gap-3 w-full">
                <button type="button" onclick="closeConfirmModal()" class="flex-1 border border-slate-200 text-slate-500 font-semibold py-3 px-4 rounded-xl hover:bg-slate-50 hover:text-slate-700 active:scale-[0.98] transition">
                    Periksa Kembali
                </button>
                <button type="button" id="confirm-submit-btn" class="flex-1 bg-[#1E6B3D] text-white font-bold py-3 px-4 rounded-xl hover:bg-[#24824A] active:scale-[0.98] transition shadow-[0_4px_12px_rgba(30,107,61,0.15)]">
                    Ya, Kirim Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ── OVERLAY LOADING SPIN ────────────────────────────────────────── -->
<div id="loading-overlay" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-slate-950/70 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300">
    <div class="relative flex items-center justify-center mb-6">
        <!-- Outer Glowing Ring -->
        <div class="absolute w-20 h-20 rounded-full border-4 border-emerald-500/20 border-t-emerald-500 animate-spin"></div>
        <!-- Inner Ring -->
        <div class="absolute w-14 h-14 rounded-full border-4 border-slate-700/30 border-b-emerald-400 animate-spin" style="animation-direction: reverse; animation-duration: 1.5s;"></div>
        <!-- Center Icon -->
        <div class="text-xl relative z-10 text-emerald-400 animate-pulse">🛡️</div>
    </div>
    
    <h3 class="text-white font-bold text-lg mb-2 tracking-wide">Memproses Permintaan Anda...</h3>
    <p class="text-slate-400 text-xs md:text-sm max-w-md text-center px-6 leading-relaxed">
        Mohon tunggu sejenak. Kami sedang memproses pendaftaran, membuat invoice, dan mengirimkan email konfirmasi ke alamat email Anda.
    </p>
</div>

<script>
    let activeFormToSubmit = null;

    function showConfirmModal(form) {
        activeFormToSubmit = form;
        
        const modal = document.getElementById('confirm-modal');
        const content = document.getElementById('confirm-content');
        
        if (modal && content) {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');
            
            setTimeout(() => {
                content.classList.remove('scale-90', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 50);
        }
    }

    function closeConfirmModal() {
        const modal = document.getElementById('confirm-modal');
        const content = document.getElementById('confirm-content');
        
        if (modal && content) {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-90', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.remove('opacity-100');
                modal.classList.add('opacity-0', 'pointer-events-none');
                activeFormToSubmit = null;
            }, 300);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            const action = form.getAttribute('action') || '';
            const method = form.getAttribute('method') || '';
            
            // Only trigger for POST forms that submit registration/pendaftaran/requests
            if (method.toUpperCase() === 'POST' && (action.includes('pendaftaran') || action.includes('request'))) {
                form.addEventListener('submit', function(e) {
                    // Check if form is valid (native HTML5 validations like required)
                    if (!form.checkValidity()) {
                        return;
                    }
                    
                    // Stop default synchronous submission so we can prompt the confirmation modal
                    e.preventDefault();
                    
                    showConfirmModal(form);
                });
            }
        });

        // Add event listener to confirm submit button
        const confirmBtn = document.getElementById('confirm-submit-btn');
        if (confirmBtn) {
            confirmBtn.addEventListener('click', function() {
                if (activeFormToSubmit) {
                    // 1. Hide confirm modal immediately
                    const modal = document.getElementById('confirm-modal');
                    const content = document.getElementById('confirm-content');
                    if (modal && content) {
                        content.classList.remove('scale-100', 'opacity-100');
                        content.classList.add('scale-90', 'opacity-0');
                        modal.classList.remove('opacity-100');
                        modal.classList.add('opacity-0', 'pointer-events-none');
                    }
                    
                    // 2. Show loading overlay
                    const overlay = document.getElementById('loading-overlay');
                    if (overlay) {
                        overlay.classList.remove('opacity-0', 'pointer-events-none');
                        overlay.classList.add('opacity-100');
                    }
                    
                    // 3. Submit form synchronously bypassing this submit listener
                    activeFormToSubmit.submit();
                }
            });
        }
    });
</script>
