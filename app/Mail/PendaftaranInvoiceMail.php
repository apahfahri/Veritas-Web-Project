<?php

namespace App\Mail;

use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\Jadwal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;

class PendaftaranInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftaran;
    public $user;
    public $layanan;

    /**
     * @param  Pendaftaran  $pendaftaran
     * @param  User         $user
     * @param  Jadwal|null  $jadwal
     */
    public function __construct(Pendaftaran $pendaftaran, User $user, ?Jadwal $jadwal = null)
    {
        $this->pendaftaran = $pendaftaran;
        $this->user        = $user;
        $this->layanan     = $jadwal ?? $pendaftaran->jadwal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $nomorPendaftaran = $this->pendaftaran->nomor_pendaftaran ?? ('#INV-' . $this->pendaftaran->id_pendaftaran);

        $kategoriNama = $this->layanan?->kategori?->nama ?? '';
        $jenisNama = $this->layanan?->jenis?->nama ?? '';
        $subject = trim("Invoice Pendaftaran {$kategoriNama} {$jenisNama}");

        $mail = $this->subject($subject)
                     ->view('emails.invoice');

        // Attempt to attach a PDF version of the invoice
        try {
            $pdf = Pdf::loadView('emails.invoice-pdf', [
                'pendaftaran' => $this->pendaftaran,
                'user'        => $this->user,
                'layanan'     => $this->layanan,
            ])->setPaper('a4', 'portrait');

            $mail->attachData(
                $pdf->output(),
                'Invoice_' . $nomorPendaftaran . '.pdf',
                ['mime' => 'application/pdf']
            );
        } catch (\Exception $e) {
            Log::warning('PendaftaranInvoiceMail: gagal generate PDF attachment. ' . $e->getMessage());
        }

        return $mail;
    }
}
