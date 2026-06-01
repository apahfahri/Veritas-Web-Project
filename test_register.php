<?php

use Illuminate\Http\Request;
use App\Http\Controllers\PendaftaranController;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap(); // Bootstrap DB, config, etc.

// Create request with session initialized (No topik_layanan for Audit!)
$request = Request::create('/pendaftaran', 'POST', [
    'kategori_id' => 3,
    'jenis_klien' => 'perusahaan',
    'nama_lengkap' => 'Jane Smith',
    'email' => 'jane.smith@example.com',
    'no_telp' => '081234567891',
    'pendidikan' => 'S1 K3',
    'nama_perusahaan' => 'CV Sumber Makmur',
    'alamat_perusahaan' => '456 Business Rd',
    'sektor_industri' => 'Manufacturing',
    'jumlah_karyawan' => 50,
    'jabatan' => 'HSE Officer',
    'tanggal_usul' => '2026-06-20',
    'mode_pertemuan' => 'offline',
    'lokasi' => 'Main Factory Hall'
]);

$request->setLaravelSession($app['session']->driver());
$app['session']->start();

// Bind request in container
$app->instance('request', $request);

try {
    $controller = $app->make(PendaftaranController::class);
    $response = $controller->store($request);
    
    echo "Status Code: " . $response->getStatusCode() . "\n";
    if ($response->isRedirection()) {
        echo "Redirect URL: " . $response->headers->get('Location') . "\n";
        
        $errors = $app['session']->get('errors');
        if ($errors) {
            echo "Errors: \n";
            print_r($errors->all());
        } else {
            echo "No validation errors.\n";
        }
        
        $success = $app['session']->get('success');
        if ($success) {
            echo "Success: $success\n";
        }
        
        $regSuccess = $app['session']->get('registration_success');
        if ($regSuccess) {
            echo "Registration success flag: true\n";
        }
    } else {
        echo "Response Content: " . substr($response->getContent(), 0, 500) . "\n";
    }
} catch (\Exception $e) {
    echo "Exception occurred: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
