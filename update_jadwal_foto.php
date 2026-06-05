<?php

use App\Models\Jadwal;

$jadwals = Jadwal::all();
$photos = ['jadwal/k3_training_1.png', 'jadwal/k3_training_2.png', 'jadwal/k3_training_3.png'];

foreach ($jadwals as $index => $jadwal) {
    $jadwal->foto = $photos[$index % count($photos)];
    $jadwal->save();
}

echo "Jadwal photos updated successfully.\n";
