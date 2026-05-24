<?php

namespace App\Mail;

use App\Models\Pendaftaran;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrainingReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftaran;
    public $jadwal;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Pendaftaran $pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
        $this->jadwal = $pendaftaran->jadwal;
        $this->user = $pendaftaran->user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $namaProgram = $this->jadwal->nama_program ?? 'Program Pelatihan';
        
        return $this->subject("[Veritas] Pengingat Pelatihan: {$namaProgram}")
                    ->view('emails.training-reminder');
    }
}
