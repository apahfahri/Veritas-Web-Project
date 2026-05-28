<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Models\Pendaftaran;

class TrainingReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftaran;

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
        $mail = $this->subject('Surat Konfirmasi Pelaksanaan Pelatihan - ' . ($this->pendaftaran->jadwal->jenis->nama ?? ''))
                     ->view('emails.training-reminder');

        $jadwal = $this->pendaftaran->jadwal;

        if ($jadwal->file_rundown) {
            $mail->attach(storage_path('app/public/' . $jadwal->file_rundown), [
                'as' => 'Rundown_Pelatihan.pdf',
                'mime' => 'application/pdf',
            ]);
        }

        foreach ($jadwal->materi as $index => $materi) {
            if ($materi->file_path) {
                $mail->attach(storage_path('app/public/' . $materi->file_path), [
                    'as' => 'Materi_' . ($index + 1) . '_' . str_replace(' ', '_', $materi->judul) . '.pdf',
                    'mime' => 'application/pdf',
                ]);
            }
        }

        return $mail;
    }
}
