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

        $namaLayanan = $this->pendaftaran->layanan?->nama ?? 'Layanan';
        $namaPeserta = $this->pendaftaran->user?->nama ?? 'Peserta';

        if ($this->status == 'menunggu_pembayaran') {
            $rekening = \App\Models\Rekening::where('status_aktif', true)->first();
            $bankName = $rekening?->nama_bank ?? 'Bank Mandiri';
            $bankAccount = $rekening?->nomor_rekening ?? '131-00-1886111-1';
            $bankRecipient = $rekening?->atas_nama ?? 'PT Katiga Veritas Indonesia';

            $message = "Halo *{$namaPeserta}*,\n\n";
            $message .= "Pendaftaran Anda pada layanan *{$namaLayanan}* telah kami terima. Untuk melanjutkan proses, silakan melakukan pembayaran ke:\n\n";
            $message .= "🏦 *{$bankName}*\n";
            $message .= "No. Rek: *{$bankAccount}*\n";
            $message .= "A/N: *{$bankRecipient}*\n\n";
            $message .= "Mohon kirimkan bukti transfer jika sudah membayar. Terima kasih!";
        } elseif ($this->status == 'diproses') {
            $message = "Halo *{$namaPeserta}*,\n\n";
            $message .= "Pendaftaran Anda pada layanan *{$namaLayanan}* saat ini sedang *DIPROSES*. Kami akan segera menghubungi Anda kembali untuk langkah selanjutnya. Terima kasih.";
        } elseif ($this->status == 'selesai') {
            $message = "Halo *{$namaPeserta}*,\n\n";
            $message .= "Selamat! Pendaftaran Anda pada layanan *{$namaLayanan}* telah *SELESAI*. Terima kasih telah mempercayakan Katiga Veritas. Semoga sukses selalu!";
        } elseif ($this->status == 'dibatalkan') {
            $message = "Halo *{$namaPeserta}*,\n\n";
            $message .= "Pendaftaran Anda pada layanan *{$namaLayanan}* telah *DIBATALKAN*. Hubungi kami jika ada pertanyaan. Terima kasih.";
        } else {
            $statusLabel = str_replace('_', ' ', strtoupper($this->status));
            $message = "Halo *{$namaPeserta}*,\n\n";
            $message .= "Update status pendaftaran *{$namaLayanan}*:\n";
            $message .= "Status: *{$statusLabel}*\n\n";
            $message .= "Terima kasih.";
        }

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

        $rekening = \App\Models\Rekening::where('status_aktif', true)->first();
        $bankName = $rekening?->nama_bank ?? 'Bank Mandiri';
        $bankAccount = $rekening?->nomor_rekening ?? '131-00-1886111-1';
        $bankRecipient = $rekening?->atas_nama ?? 'PT Katiga Veritas Indonesia';

        $message = "✅ *KONFIRMASI PENDAFTARAN - KATIGA VERITAS*\n\n";
        $message .= "Halo *{$namaPeserta}*,\n";
        $message .= "Terima kasih telah mendaftar untuk layanan:\n";
        $message .= "📌 *{$namaLayanan}*\n\n";
        $message .= "💵 *DETAIL PEMBAYARAN:*\n";
        $message .= "Total Tagihan: *Rp {$nominal}*\n\n";
        $message .= "Silakan melakukan transfer ke rekening berikut:\n";
        $message .= "🏦 *{$bankName}*\n";
        $message .= "No. Rek: *{$bankAccount}*\n";
        $message .= "A/N: *{$bankRecipient}*\n\n";
        $message .= "Setelah melakukan transfer, mohon unggah bukti bayar pada halaman status pendaftaran Anda. Terima kasih.";

        return Http::withHeaders([
            'Authorization' => $apiKey
        ])->post($url, [
            'target' => $targetNumber,
            'message' => $message,
        ]);
    }
}
