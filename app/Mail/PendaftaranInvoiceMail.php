<?php

namespace App\Mail;

use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\Layanan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendaftaranInvoiceMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $pendaftaran;
    public $user;
    public $layanan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Pendaftaran $pendaftaran, User $user, Layanan $layanan)
    {
        $this->pendaftaran = $pendaftaran;
        $this->user = $user;
        $this->layanan = $layanan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[Veritas] Invoice Pendaftaran Program Pelatihan - #INV-' . $this->pendaftaran->id_pendaftaran)
                    ->view('emails.invoice');
    }
}
