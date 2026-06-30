<?php
$file = 'resources/views/subadmin/pelatihan-kustom/show.blade.php';
$content = file_get_contents($file);

// 1. Replace emojis with flaticons
$replacements = [
    '👀' => '<i class="fi fi-rr-eye text-2xl"></i>',
    '📅' => '<i class="fi fi-rr-calendar text-2xl"></i>',
    '💳' => '<i class="fi fi-rr-credit-card text-2xl"></i>',
    '🔍' => '<i class="fi fi-rr-search text-2xl"></i>',
    '🚀' => '<i class="fi fi-rr-rocket-lunch text-2xl"></i>',
    '✅' => '<i class="fi fi-rr-check-circle text-2xl"></i>',
    '❌' => '<i class="fi fi-rr-cross-circle text-2xl"></i>',
    '✓' => '<i class="fi fi-rr-check text-[10px]"></i>',
    '✕' => '<i class="fi fi-rr-cross text-[10px]"></i>',
    '👥' => '<i class="fi fi-rr-users"></i>',
    '➕' => '<i class="fi fi-rr-plus"></i>',
    '📥' => '<i class="fi fi-rr-download"></i>',
    '🗒️' => '<i class="fi fi-rr-notebook"></i>',
    '❌ Hapus' => '<i class="fi fi-rr-trash"></i> Hapus'
];

// Specific select options replacement so we don't inject HTML into <option> text
$content = str_replace('🌐 Online (Classroom/Meet)', 'Online (Classroom/Meet)', $content);
$content = str_replace('🏢 Offline (In-House Training)', 'Offline (In-House Training)', $content);
$content = str_replace('🔗 Hybrid', 'Hybrid', $content);

foreach ($replacements as $emoji => $flaticon) {
    // Only replace outside of HTML attributes or tags if possible, but str_replace is fine here
    // since emojis don't appear in class names.
    $content = str_replace($emoji, $flaticon, $content);
}

// 2. We need to swap the columns and move blocks around.
// The structure is:
// <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
//     <div class="lg:col-span-2 space-y-6">
//         [Stepper Card]
//         [Dynamic Action Card]
//     </div>
//     <div class="space-y-6">
//         [Daftar Peserta]
//         [Profil Perusahaan]
//         [Data PIC]
//         [Pengajuan Awal]
//     </div>
// </div>

// We want:
// <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
//     <div class="lg:col-span-2 space-y-6">
//         [Profil Perusahaan]
//         [Data PIC]
//         [Pengajuan Awal]
//         [Daftar Peserta]
//         [Dynamic Action Card]
//     </div>
//     <div class="lg:col-span-1 space-y-6">
//         [Stepper Card]
//     </div>
// </div>

// To do this reliably with string manipulation, we'll extract each card using regex or string positions.

function extractCard($content, $startMarker, $endMarkerLengthApprox = 5) {
    $start = strpos($content, $startMarker);
    if ($start === false) return null;
    
    // Find the end of the card by matching div pairs
    $pos = $start;
    $divCount = 0;
    $started = false;
    $end = 0;
    
    while ($pos < strlen($content)) {
        if (substr($content, $pos, 4) == '<div') {
            $divCount++;
            $started = true;
        } elseif (substr($content, $pos, 5) == '</div') {
            $divCount--;
        }
        
        $pos++;
        
        if ($started && $divCount == 0) {
            $end = $pos + 5; // include '> '
            break;
        }
    }
    
    return substr($content, $start, $end - $start);
}

// Cards to extract:
$stepperCard = extractCard($content, '{{-- ── STEPPER CARD ──────────────────────────────────────── --}}');
$actionCard = extractCard($content, '{{-- ── DYNAMIC ACTION CARD ────────────────────────────────── --}}');
$pesertaCard = extractCard($content, '{{-- ── DAFTAR PESERTA CARD IN SIDEBAR ─────────────────────── --}}');
$perusahaanCard = extractCard($content, '{{-- Profil Perusahaan --}}');
$picCard = extractCard($content, '{{-- Data PIC --}}');
$pengajuanCard = extractCard($content, '{{-- Pengajuan Awal --}}');

// If we found them all, we reconstruct the grid.
if ($stepperCard && $actionCard && $pesertaCard && $perusahaanCard && $picCard && $pengajuanCard) {
    // Find grid start and end
    $gridStart = strpos($content, '<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">');
    // Find the end of the grid (line 693 usually)
    // We can just find the comment "<!-- Modal Import Peserta -->"
    $gridEndPos = strpos($content, '<!-- Modal Import Peserta -->');
    
    if ($gridStart !== false && $gridEndPos !== false) {
        $beforeGrid = substr($content, 0, $gridStart);
        $afterGrid = substr($content, $gridEndPos);
        
        $newGrid = <<<EOD
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- LEFT / MAIN COLUMN (Dominant Information)                        --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <div class="lg:col-span-2 space-y-6">
        $perusahaanCard
        $picCard
        $pengajuanCard
        $pesertaCard
        $actionCard
    </div>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- RIGHT / SIDEBAR COLUMN (Stepper)                               --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <div class="lg:col-span-1 space-y-6">
        $stepperCard
    </div>
</div>

EOD;
        
        $finalContent = $beforeGrid . $newGrid . $afterGrid;
        file_put_contents($file, $finalContent);
        echo "Successfully rewrote layout!";
    } else {
        echo "Error: Grid start/end not found.";
    }
} else {
    echo "Error: Could not extract all cards.";
}

