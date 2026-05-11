<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class PendaftaranStatusNotification extends Notification
{
    use Queueable;

    protected $pendaftaran;
    protected $status;

    public function __construct($pendaftaran, $status)
    {
        $this->pendaftaran = $pendaftaran;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        // We will use a custom channel logic or just call the API directly here for simplicity
        // as per generic implementation request
        return ['database']; // Default to DB, but we'll trigger WA manually or via a custom channel
    }

    public function toArray($notifiable)
    {
        return [
            'pendaftaran_id' => $this->pendaftaran->id_pendaftaran,
            'status' => $this->status,
            'message' => 'Status pendaftaran Anda telah diperbarui menjadi ' . $this->status,
        ];
    }

    /**
     * Generic WhatsApp Sender (Fonnte/Wablas Style)
     */
    public function sendWhatsapp($targetNumber)
    {
        $apiKey = config('services.whatsapp.api_key', 'YOUR_API_KEY_HERE');
        $url = config('services.whatsapp.url', 'https://api.fonnte.com/send');

        $statusLabel = str_replace('_', ' ', strtoupper($this->status));
        $namaLayanan = $this->pendaftaran->layanan?->nama ?? 'Layanan';
        $namaPeserta = $this->pendaftaran->user?->nama ?? 'Peserta';

        $message = "Halo *{$namaPeserta}*,\n\n";
        $message .= "Update status untuk pendaftaran Anda pada layanan *{$namaLayanan}*:\n";
        $message .= "Status saat ini: *{$statusLabel}*\n\n";
        $message .= "Silakan cek detail pendaftaran Anda di dashboard. Terima kasih.";

        return Http::withHeaders([
            'Authorization' => $apiKey
        ])->post($url, [
            'target' => $targetNumber,
            'message' => $message,
        ]);
    }

    /**
     * Send WA Invoice for new registration
     */
    public function sendInvoice($targetNumber)
    {
        $apiKey = config('services.whatsapp.api_key', 'YOUR_API_KEY_HERE');
        $url = config('services.whatsapp.url', 'https://api.fonnte.com/send');

        $namaLayanan = $this->pendaftaran->layanan?->nama ?? 'Layanan';
        $namaPeserta = $this->pendaftaran->user?->nama ?? 'Peserta';
        $nominal = number_format($this->pendaftaran->layanan?->harga ?? 0, 0, ',', '.');

        $message = "✅ *KONFIRMASI PENDAFTARAN - KATIGA VERITAS*\n\n";
        $message .= "Halo *{$namaPeserta}*,\n";
        $message .= "Terima kasih telah mendaftar untuk layanan:\n";
        $message .= "📌 *{$namaLayanan}*\n\n";
        $message .= "💵 *DETAIL PEMBAYARAN:*\n";
        $message .= "Total Tagihan: *Rp {$nominal}*\n\n";
        $message .= "Silakan melakukan transfer ke rekening berikut:\n";
        $message .= "🏦 *Bank Mandiri*\n";
        $message .= "No. Rek: *1310018861111*\n";
        $message .= "A/N: *PT Katiga Veritas Indonesia*\n\n";
        $message .= "Setelah melakukan transfer, mohon unggah bukti bayar pada halaman status pendaftaran Anda. Terima kasih.";

        return Http::withHeaders([
            'Authorization' => $apiKey
        ])->post($url, [
            'target' => $targetNumber,
            'message' => $message,
        ]);
    }
}
