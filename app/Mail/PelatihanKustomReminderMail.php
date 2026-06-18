<?php

namespace App\Mail;

use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PelatihanKustomReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftaran;
    public $participant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Pendaftaran $pendaftaran, User $participant)
    {
        $this->pendaftaran = $pendaftaran;
        $this->participant = $participant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Surat Undangan & Pelaksanaan Pelatihan Kustom - ' . ($this->pendaftaran->perusahaan?->nama ?? 'PT Veritas'))
                    ->view('emails.surat-pelaksanaan');
    }
}
