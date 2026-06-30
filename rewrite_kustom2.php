<?php
$file = 'resources/views/subadmin/pelatihan-kustom/show.blade.php';
$content = file_get_contents($file);

function extractCard(&$content, $startMarker) {
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
    
    $card = substr($content, $start, $end - $start);
    // Remove the card from the original content
    $content = substr_replace($content, '', $start, $end - $start);
    return $card;
}

// We will read the whole grid block, extract each card, and then reassemble.
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
    // The previous extraction removed all cards, so the grid is basically empty now except for wrappers.
    // Actually, extracting modifies $content, but leaves the empty grid wrappers.
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
        $actionCard
    </div>

    {{-- ══════════════════════════════════════════════════════════════ --}}
    {{-- RIGHT / SIDEBAR COLUMN                                         --}}
    {{-- ══════════════════════════════════════════════════════════════ --}}
    <div class="lg:col-span-1 space-y-6">
        $stepperCard
        $pesertaCard
    </div>
</div>

EOD;
        
        $finalContent = $beforeGrid . $newGrid . $afterGrid;
        file_put_contents($file, $finalContent);
        echo "Successfully rewrote layout with Peserta Card on the right!";
    } else {
        echo "Error: Grid start/end not found.";
    }
} else {
    echo "Error: Could not extract all cards.";
}

