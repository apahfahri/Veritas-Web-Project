@if(session('success'))
<div id="success-modal" class="fixed inset-0 z-[9999] flex items-center justify-center bg-[#7d2ae7]/20 backdrop-blur-md transition-opacity duration-500">
    <div class="bg-white rounded-[2rem] p-10 max-w-sm w-full mx-6 shadow-[0_20px_50px_rgba(125,42,231,0.3)] transform transition-all duration-500 scale-90 opacity-0" id="success-content">
        <div class="flex flex-col items-center text-center">
            
            {{-- Checkmark Wrapper --}}
            <div class="w-24 h-24 mb-6 relative">
                <div class="absolute inset-0 bg-[#4CAF50]/10 rounded-full animate-ping"></div>
                <div class="success-checkmark relative z-10">
                    <div class="check-icon">
                        <span class="icon-line line-tip"></span>
                        <span class="icon-line line-long"></span>
                        <div class="icon-circle"></div>
                        <div class="icon-fix"></div>
                    </div>
                </div>
            </div>

            <h3 class="text-3xl font-black text-[#7d2ae7] mb-3 tracking-tight">Berhasil!</h3>
            <p class="text-gray-500 leading-relaxed mb-8 px-2">{{ session('success') }}</p>
            
            <button onclick="closeSuccessModal()" class="group relative w-full overflow-hidden bg-[#7d2ae7] text-white font-bold py-4 rounded-2xl transition-all hover:shadow-[0_10px_20px_rgba(125,42,231,0.4)] active:scale-95">
                <span class="relative z-10">Lanjutkan</span>
                <div class="absolute inset-0 bg-gradient-to-r from-[#7d2ae7] via-[#3969e7] to-[#07b9ce] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </button>
        </div>
    </div>
</div>

<style>
.success-checkmark {
    width: 96px;
    height: 96px;
    margin: 0 auto;
}
.success-checkmark .check-icon {
    width: 96px;
    height: 96px;
    position: relative;
    border-radius: 50%;
    box-sizing: content-box;
    border: 4px solid #4CAF50;
}
.success-checkmark .check-icon::before {
    top: 3px;
    left: -2px;
    width: 36px;
    transform-origin: 100% 50%;
    border-radius: 100px 0 0 100px;
}
.success-checkmark .check-icon::after {
    top: 0;
    left: 36px;
    width: 72px;
    transform-origin: 0 50%;
    border-radius: 0 100px 100px 0;
    animation: rotate-circle 4.25s ease-in;
}
.success-checkmark .check-icon::before, .success-checkmark .check-icon::after {
    content: '';
    height: 120px;
    position: absolute;
    background: #FFFFFF;
    transform: rotate(-45deg);
}
.success-checkmark .check-icon .icon-line {
    height: 6px;
    background-color: #4CAF50;
    display: block;
    border-radius: 2px;
    position: absolute;
    z-index: 10;
}
.success-checkmark .check-icon .icon-line.line-tip {
    top: 55px;
    left: 17px;
    width: 30px;
    transform: rotate(45deg);
    animation: icon-line-tip 0.75s;
}
.success-checkmark .check-icon .icon-line.line-long {
    top: 45px;
    right: 10px;
    width: 56px;
    transform: rotate(-45deg);
    animation: icon-line-long 0.75s;
}
.success-checkmark .check-icon .icon-circle {
    top: -4px;
    left: -4px;
    z-index: 10;
    width: 96px;
    height: 96px;
    border-radius: 50%;
    position: absolute;
    box-sizing: content-box;
    border: 4px solid rgba(76, 175, 80, .5);
}
.success-checkmark .check-icon .icon-fix {
    top: 10px;
    width: 6px;
    left: 33px;
    z-index: 1;
    height: 102px;
    position: absolute;
    transform: rotate(-45deg);
    background-color: #FFFFFF;
}

@keyframes rotate-circle {
    0% { transform: rotate(-45deg); }
    5% { transform: rotate(-45deg); }
    12% { transform: rotate(-405deg); }
    100% { transform: rotate(-405deg); }
}
@keyframes icon-line-tip {
    0% { width: 0; left: 1px; top: 19px; }
    54% { width: 0; left: 1px; top: 19px; }
    70% { width: 60px; left: -8px; top: 37px; }
    84% { width: 20px; left: 25px; top: 58px; }
    100% { width: 30px; left: 17px; top: 55px; }
}
@keyframes icon-line-long {
    0% { width: 0; right: 46px; top: 54px; }
    65% { width: 0; right: 46px; top: 54px; }
    84% { width: 66px; right: 0px; top: 42px; }
    100% { width: 56px; right: 10px; top: 45px; }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('success-modal');
        const content = document.getElementById('success-content');
        
        if (modal) {
            setTimeout(() => {
                content.classList.remove('scale-90', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 100);
        }
    });

    function closeSuccessModal() {
        const modal = document.getElementById('success-modal');
        const content = document.getElementById('success-content');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-90', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.remove();
            }, 500);
        }, 100);
    }
</script>
@endif
