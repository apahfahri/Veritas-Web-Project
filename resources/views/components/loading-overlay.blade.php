<!-- ── CONFIRMATION MODAL ────────────────────────────────────────────── -->
<div id="confirm-modal" class="fixed inset-0 z-[9998] flex items-center justify-center bg-slate-950/60 backdrop-blur-md opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-6 border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.15)] transform transition-all duration-300 scale-90 opacity-0" id="confirm-content">
        <div class="flex flex-col items-center text-center">
            <!-- Icon -->
            <div class="w-16 h-16 mb-4 bg-emerald-50 text-[#1E6B3D] rounded-2xl flex items-center justify-center text-3xl shadow-inner border border-emerald-100 animate-pulse">
                <i class="fi fi-rr-shield-check"></i>
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
        <div class="text-xl relative z-10 text-emerald-400 animate-pulse">
            <i class="fi fi-rr-shield-check"></i>
        </div>
    </div>
    
    <h3 id="loading-overlay-title" class="text-white font-bold text-lg mb-2 tracking-wide">Memproses Permintaan Anda...</h3>
    <p id="loading-overlay-desc" class="text-slate-400 text-xs md:text-sm max-w-md text-center px-6 leading-relaxed">
        Mohon tunggu sejenak. Kami sedang memproses pendaftaran, membuat invoice, dan mengirimkan email konfirmasi ke alamat email Anda.
    </p>
</div>

<script>
    let activeFormToSubmit = null;

    // Global helpers to show/hide loading overlay programmatically
    window.showLoadingOverlay = function(title = 'Memproses...', desc = 'Mohon tunggu sejenak, kami sedang memproses permintaan Anda.') {
        const overlay = document.getElementById('loading-overlay');
        const titleEl = document.getElementById('loading-overlay-title');
        const descEl = document.getElementById('loading-overlay-desc');
        
        if (title || desc) {
            if (titleEl) {
                titleEl.textContent = title;
                titleEl.classList.remove('hidden');
            }
            if (descEl) {
                descEl.textContent = desc;
                descEl.classList.remove('hidden');
            }
        } else {
            // Hide text completely when both are empty
            if (titleEl) titleEl.classList.add('hidden');
            if (descEl) descEl.classList.add('hidden');
        }
        
        if (overlay) {
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100');
        }
    };

    window.hideLoadingOverlay = function() {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0', 'pointer-events-none');
        }
    };

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
        // 1. Intercept POST forms for loading triggers
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            const action = form.getAttribute('action') || '';
            const method = form.getAttribute('method') || '';
            
            if (method.toUpperCase() === 'POST') {
                // If it is a booking/pendaftaran/request form, intercept with confirmation modal
                if (action.includes('pendaftaran') || action.includes('request')) {
                    form.addEventListener('submit', function(e) {
                        if (!form.checkValidity()) {
                            return;
                        }
                        
                        e.preventDefault();
                        showConfirmModal(form);
                    });
                } else {
                    // For ordinary POST forms, show loading overlay directly on submit
                    form.addEventListener('submit', function(e) {
                        if (!form.checkValidity()) {
                            return;
                        }
                        
                        let title = 'Memproses Permintaan Anda...';
                        let desc = 'Mohon tunggu sejenak, kami sedang memproses data Anda.';
                        
                        if (action.includes('login')) {
                            title = 'Mencoba Masuk...';
                            desc = 'Mohon tunggu sejenak. Kami sedang memverifikasi kredensial akun Anda.';
                        } else if (action.includes('register')) {
                            title = 'Membuat Akun...';
                            desc = 'Mohon tunggu sejenak. Kami sedang mendaftarkan akun Anda dan menyiapkan sistem.';
                        } else if (action.includes('otp') || action.includes('verify')) {
                            title = 'Memverifikasi Kode OTP...';
                            desc = 'Mohon tunggu sejenak. Kami sedang mencocokkan kode keamanan Anda.';
                        } else if (action.includes('profile')) {
                            title = 'Menyimpan Perubahan...';
                            desc = 'Mohon tunggu sejenak. Kami sedang memperbarui data profil Anda.';
                        } else if (action.includes('password') || action.includes('reset')) {
                            title = 'Mengirim Permintaan Sandi...';
                            desc = 'Mohon tunggu sejenak. Kami sedang menghubungkan ke server email untuk memproses reset sandi.';
                        } else if (action.includes('logout')) {
                            title = 'Keluar dari Sistem...';
                            desc = 'Mohon tunggu sejenak. Sesi Anda sedang dibersihkan secara aman.';
                        }
                        
                        window.showLoadingOverlay(title, desc);
                    });
                }
            }
        });

        // 2. Intercept link clicks for page navigation loading (without text)
        document.querySelectorAll('a').forEach(link => {
            const href = link.getAttribute('href');
            const target = link.getAttribute('target');
            
            // Validate that the link is for local page navigation
            if (href && 
                !href.startsWith('#') && 
                !href.startsWith('javascript:') && 
                !href.startsWith('mailto:') && 
                !href.startsWith('tel:') && 
                (!target || target === '_self') &&
                !link.hasAttribute('download')) {
                
                try {
                    const url = new URL(link.href, window.location.href);
                    if (url.origin === window.location.origin) {
                        link.addEventListener('click', function(e) {
                            // Do not intercept modifier clicks (Ctrl+Click, etc.)
                            if (e.metaKey || e.ctrlKey || e.shiftKey || (e.button && e.button === 1)) {
                                return;
                            }
                            
                            // Show loading overlay without text
                            window.showLoadingOverlay('', '');
                        });
                    }
                } catch(e) {}
            }
        });

        // 3. Add event listener to confirm submit button
        const confirmBtn = document.getElementById('confirm-submit-btn');
        if (confirmBtn) {
            confirmBtn.addEventListener('click', function() {
                if (activeFormToSubmit) {
                    // Hide confirm modal immediately
                    const modal = document.getElementById('confirm-modal');
                    const content = document.getElementById('confirm-content');
                    if (modal && content) {
                        content.classList.remove('scale-100', 'opacity-100');
                        content.classList.add('scale-90', 'opacity-0');
                        modal.classList.remove('opacity-100');
                        modal.classList.add('opacity-0', 'pointer-events-none');
                    }
                    
                    // Show loading overlay
                    const kategoriInput = activeFormToSubmit.querySelector('input[name="kategori_id"]');
                    const isConsultation = kategoriInput && kategoriInput.value === '2';
                    const isAudit = kategoriInput && kategoriInput.value === '3';
                    
                    let title = 'Memproses Pendaftaran...';
                    let desc = 'Mohon tunggu sejenak. Kami sedang memproses pendaftaran, membuat invoice, dan mengirimkan email konfirmasi ke alamat email Anda.';
                    
                    if (isConsultation) {
                        title = 'Mengirim Permintaan Konsultasi...';
                        desc = 'Mohon tunggu sejenak. Kami sedang memproses data pengajuan konsultasi Anda.';
                    } else if (isAudit) {
                        title = 'Mengirim Permintaan Audit...';
                        desc = 'Mohon tunggu sejenak. Kami sedang memproses data pengajuan audit K3 Anda.';
                    }

                    window.showLoadingOverlay(title, desc);
                    
                    // Submit form
                    activeFormToSubmit.submit();
                }
            });
        }
    });

    // Handle back button / cache reload
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.hideLoadingOverlay();
        }
    });
</script>
