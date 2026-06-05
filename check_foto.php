<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

use App\Models\Jadwal;

// Check all jadwal and their foto
echo "=== ALL JADWAL FOTO ===\n";
$all = Jadwal::select('id_jadwal', 'foto')->get();
foreach ($all as $j) {
    $foto = $j->foto;
    $storageExists = $foto ? file_exists(storage_path('app/public/' . $foto)) : false;
    $publicExists  = $foto ? file_exists(public_path('storage/' . $foto)) : false;
    echo "[jadwal #{$j->id_jadwal}] foto='{$foto}' storage=" . ($storageExists ? 'OK' : 'MISSING') . " public=" . ($publicExists ? 'OK' : 'MISSING') . "\n";
}

echo "\n=== STORAGE SYMLINK ===\n";
$link = public_path('storage');
echo "public/storage link: " . (is_link($link) ? 'EXISTS -> ' . readlink($link) : (is_dir($link) ? 'IS DIR (NOT SYMLINK)' : 'MISSING')) . "\n";

echo "\n=== STORAGE FILES ===\n";
$dir = storage_path('app/public');
if (is_dir($dir)) {
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($rii as $file) {
        if ($file->isFile()) {
            echo $file->getPathname() . "\n";
        }
    }
} else {
    echo "storage/app/public directory does not exist!\n";
}
