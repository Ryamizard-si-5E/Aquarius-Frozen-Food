<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PelangganRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pelanggan;

    public function __construct($pelanggan)
    {
        $this->pelanggan = $pelanggan;
    }

    public function build()
    {
        return $this->subject('Pendaftaran Akun Ditolak')
            ->html("
                <h2>Halo {$this->pelanggan->nama_pelanggan},</h2>
                <p>Mohon maaf, pendaftaran akun Anda dengan username <b>{$this->pelanggan->username}</b> <b>ditolak</b> oleh admin.</p>
                <p>Terima kasih.</p>
            ");
    }
}
