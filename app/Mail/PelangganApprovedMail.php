<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PelangganApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pelanggan;

    public function __construct($pelanggan)
    {
        $this->pelanggan = $pelanggan;
    }

    public function build()
    {
        return $this->subject('Akun Anda Disetujui')
            ->html("
                <h2>Halo {$this->pelanggan->nama_pelanggan},</h2>
                <p>Selamat! Akun Anda dengan username <b>{$this->pelanggan->username}</b> telah <b>disetujui</b> oleh admin.</p>
                <p>Sekarang Anda bisa login dan mulai berbelanja di <b>Aquarius Frozen Food</b>.</p>
                <p>Silahkan Klik Link Dibawah Ini</p>
                <p>Terima kasih 🙏</p>
            ");
    }
}
