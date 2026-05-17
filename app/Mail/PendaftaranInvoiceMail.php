<?php

namespace App\Mail;

use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\Layanan;
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
     * @param  Layanan|null $layanan
     */
    public function __construct(Pendaftaran $pendaftaran, User $user, ?Layanan $layanan = null)
    {
        $this->pendaftaran = $pendaftaran;
        $this->user        = $user;
        $this->layanan     = $layanan ?? $pendaftaran->layanan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $invNo = $this->pendaftaran->id_pendaftaran;

        $mail = $this->subject('[Veritas] Invoice Pendaftaran #INV-' . $invNo)
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
                'Invoice_INV-' . $invNo . '.pdf',
                ['mime' => 'application/pdf']
            );
        } catch (\Exception $e) {
            Log::warning('PendaftaranInvoiceMail: gagal generate PDF attachment. ' . $e->getMessage());
        }

        return $mail;
    }
}
