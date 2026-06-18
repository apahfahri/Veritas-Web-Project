    function showKonfirmasiModal() {
        const modal = document.getElementById('confirmModal');
        const targetName = document.getElementById('targetStatusName');
        const message = document.getElementById('confirmMessage');
        const confirmBtn = document.getElementById('confirmBtnAction');
        const iconContainer = document.getElementById('confirmIconContainer');
        const icon = document.getElementById('confirmIcon');

        targetName.innerText = "Konfirmasi Lunas";
        message.innerHTML = "Apakah Anda yakin mengonfirmasi pembayaran ini sebagai Lunas? Status progres akan otomatis berubah menjadi <span class='text-emerald-600 font-bold uppercase'>Terkonfirmasi</span>.";
        modal.classList.remove('hidden');

        // Emerald theme for konfirmasi
        iconContainer.className = "w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center mx-auto mb-6";
        icon.className = "w-8 h-8 text-emerald-600";
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
        
        confirmBtn.className = "flex-1 py-5 text-xs font-black text-emerald-600 hover:bg-emerald-50 transition uppercase tracking-widest";
        confirmBtn.innerText = "Ya, Konfirmasi";

        confirmBtn.onclick = function() {
            document.getElementById('formKonfirmasiBukti').submit();
        };
    }

    function showTolakModal() {
        const modal = document.getElementById('confirmModal');
        const targetName = document.getElementById('targetStatusName');
        const message = document.getElementById('confirmMessage');
        const confirmBtn = document.getElementById('confirmBtnAction');
        const iconContainer = document.getElementById('confirmIconContainer');
        const icon = document.getElementById('confirmIcon');

        targetName.innerText = "Tolak Bukti";
        message.innerHTML = "Tandai bukti pembayaran sebagai tidak valid? Pendaftaran akan diubah menjadi status <span class='text-red-600 font-bold uppercase'>Dibatalkan</span>.";
        modal.classList.remove('hidden');

        // Red theme for tolak
        iconContainer.className = "w-16 h-16 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-6";
        icon.className = "w-8 h-8 text-red-600";
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
        
        confirmBtn.className = "flex-1 py-5 text-xs font-black text-red-600 hover:bg-red-50 transition uppercase tracking-widest";
        confirmBtn.innerText = "Ya, Tolak Bukti";

        confirmBtn.onclick = function() {
            document.getElementById('formTolakBukti').submit();
        };
    }

    function confirmDelete() {
        const modal = document.getElementById('confirmModal');
        const targetName = document.getElementById('targetStatusName');
        const message = document.getElementById('confirmMessage');
        const confirmBtn = document.getElementById('confirmBtnAction');
        const iconContainer = document.getElementById('confirmIconContainer');
        const icon = document.getElementById('confirmIcon');

        targetName.innerText = "Hapus Pendaftaran";
        message.innerHTML = "Tindakan ini <span class='text-red-600 font-bold uppercase'>permanen</span>. Seluruh data pendaftaran ini akan dihapus dari sistem.";
        modal.classList.remove('hidden');

        // Red theme for delete
        iconContainer.className = "w-16 h-16 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-6";
        icon.className = "w-8 h-8 text-red-600";
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>';

        confirmBtn.className = "flex-1 py-5 text-xs font-black text-red-600 hover:bg-red-50 transition uppercase tracking-widest";
        confirmBtn.innerText = "Ya, Hapus";

        confirmBtn.onclick = function() {
            document.getElementById('deleteForm').submit();
        };
    }