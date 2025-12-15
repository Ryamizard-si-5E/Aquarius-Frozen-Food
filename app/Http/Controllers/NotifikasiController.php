<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    // Menampilkan notifikasi pelanggan yang sedang login
   public function notifikasi()
{
    $idPelanggan = auth('pelanggan')->id(); // ambil id dari guard pelanggan

    $notifikasi = Notifikasi::where('id_pelanggan', $idPelanggan)
        ->latest()
        ->get();

    return view('notifikasi', compact('notifikasi'));
}

    // Admin atau sistem bisa menambah notifikasi
    public function store(Request $request)
{
    $notif = new Notifikasi();
    $notif->id_pelanggan = auth('pelanggan')->id(); // simpan sesuai pelanggan login
    $notif->pesan = $request->pesan;
    $notif->is_read = 0;
    $notif->save();

    return redirect()->back()->with('success', 'Notifikasi berhasil ditambahkan');
}

}
