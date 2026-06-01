<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Pendaftaran;

class AuditScheduleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftaran;

    /**
     * Create a new message instance.
     *
     * @param Pendaftaran $pendaftaran
     */
    public function __construct(Pendaftaran $pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $programName = $this->pendaftaran->jadwal->jenis->nama ?? 'Audit';
        return $this->subject('Konfirmasi Jadwal Pelaksanaan Audit - ' . $programName)
                    ->view('emails.audit-schedule');
    }
}
