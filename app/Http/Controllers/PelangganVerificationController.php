<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Mail\PelangganApprovedMail;
use App\Mail\PelangganRejectedMail;
use Illuminate\Support\Facades\Mail;

class PelangganVerificationController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::where('status', 'pending')->get();
        return view('verify-pelanggan', compact('pelanggan'));
    }

    public function approve(Pelanggan $pelanggan)
    {
        $pelanggan->update(['status' => 'active']);

        // Kirim email ke pelanggan
        Mail::to($pelanggan->email)->send(new PelangganApprovedMail($pelanggan));

        return back()->with('success', 'Pelanggan berhasil disetujui & email terkirim.');
    }

   public function reject(Pelanggan $pelanggan)
{
    // Simpan email dulu buat kirim pesan sebelum dihapus
    $email = $pelanggan->email;

    // Hapus pelanggan dari database
    $pelanggan->delete();

    // Kirim email pemberitahuan
    Mail::to($email)->send(new PelangganRejectedMail($pelanggan));

    return back()->with('success', 'Pelanggan ditolak, data dihapus & email terkirim.');
}


    public function verifikasi($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        // Cek apakah nomor sudah dipakai pelanggan lain yang disetujui
        $nomorSudahAda = Pelanggan::where('no_hp', $pelanggan->no_hp)
            ->where('status', 'active') // hanya cek yang sudah aktif
            ->where('id_pelanggan', '!=', $pelanggan->id_pelanggan)
            ->exists();

        return view('verify-pelanggan', compact('pelanggan', 'nomorSudahAda'));
    }
}
