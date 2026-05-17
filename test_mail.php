<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\Layanan;
use App\Mail\PendaftaranInvoiceMail;

try {
    $pendaftaran = Pendaftaran::first();
    $user = User::first();
    $layanan = Layanan::first();

    if ($pendaftaran && $user && $layanan) {
        // change email to the mail config's from address so it doesn't spam random users, or use my test email
        Mail::to('test@example.com')->send(new PendaftaranInvoiceMail($pendaftaran, $user, $layanan));
        echo "Mail sent successfully.\n";
    } else {
        echo "Missing data to send mail.\n";
    }
} catch (\Exception $e) {
    echo "Error sending mail: " . $e->getMessage() . "\n";
}
