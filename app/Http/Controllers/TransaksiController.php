<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Detail;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use App\Models\Notifikasi;

class TransaksiController extends Controller
{
    public function index()
    {
        // Ambil data transaksi + detail + pelanggan
        $transaksi = Transaksi::with(['pelanggan', 'details.barang'])->get();
        return view('transaksi', compact('transaksi'));
    }

    public function terima($id_transaksi)
{
    DB::transaction(function () use ($id_transaksi) {
        $transaksi = Transaksi::find($id_transaksi);
        if ($transaksi && $transaksi->status === 'pending') {
            $details = Detail::where('id_transaksi', $id_transaksi)->get();
            foreach ($details as $detail) {
                $barang = Barang::find($detail->id_barang);
                if ($barang) {
                    $barang->stok -= $detail->jumlah_barang;
                    $barang->save();
                }
            }

            $transaksi->status = 'diterima';
            $transaksi->save();

            // 🔔 Tambahkan notifikasi langsung ke pelanggan
            Notifikasi::create([
                'id_pelanggan' => $transaksi->id_pelanggan,
                'pesan' => 'Pesanan Anda dengan ID '.$transaksi->id_transaksi.' dengan total harga '.$transaksi->total_harga.' pada tanggal '.$transaksi->tanggal.' telah DITERIMA Terimakasi.',
                'is_read' => 0,
            ]);
        }
    });

    return redirect()->back()->with('success', 'Transaksi diterima, stok diperbarui & notifikasi terkirim!');
}

public function tolak($id_transaksi)
{
    $transaksi = Transaksi::find($id_transaksi);

    if ($transaksi && $transaksi->status === 'pending') {

        // 🔄 Kembalikan stok untuk setiap item transaksi
        $detailItems = Detail::where('id_transaksi', $id_transaksi)->get();

        foreach ($detailItems as $item) {
            $barang = Barang::find($item->id_barang);
            if ($barang) {
                $barang->stok += $item->jumlah_barang; // tambah stok kembali
                $barang->save();
            }
        }

        // 🔄 Update status transaksi jadi ditolak
        $transaksi->status = 'ditolak';
        $transaksi->save();

        // 🔔 Tambahkan notifikasi langsung ke pelanggan
        Notifikasi::create([
            'id_pelanggan' => $transaksi->id_pelanggan,
            'pesan' => 'Pesanan Anda dengan ID '.$transaksi->id_transaksi.' dengan total harga '.$transaksi->total_harga.' pada tanggal '.$transaksi->tanggal.' telah DITOLAK oleh admin.',
            'is_read' => 0,
        ]);
    }

    return redirect()->back()->with('success', 'Transaksi ditolak, stok dikembalikan & notifikasi terkirim!');
}
public function updatePengiriman($id, $status)
{
    $transaksi = Transaksi::findOrFail($id);

    if ($transaksi->status === 'diterima') {
        $transaksi->status_pengiriman = $status;
        $transaksi->save();

        // 🔔 Buat pesan notifikasi sesuai status
        $pesan = match ($status) {
            'diproses' => 'Pesanan Anda dengan ID '.$transaksi->id_transaksi.' sedang DIPROSES oleh penjual.',
            'dikirim'  => 'Pesanan Anda dengan ID '.$transaksi->id_transaksi.' sudah DIKIRIM, mohon ditunggu.',
            'selesai'  => 'Pesanan Anda dengan ID '.$transaksi->id_transaksi.' telah SELESAI. Terima kasih sudah berbelanja!',
            default    => 'Status pengiriman pesanan Anda diperbarui.'
        };

        // 🔔 Tambahkan notifikasi ke pelanggan
        Notifikasi::create([
            'id_pelanggan' => $transaksi->id_pelanggan,
            'pesan'        => $pesan,
            'is_read'      => 0,
        ]);
    }

    return back()->with('success', "Status pengiriman berhasil diperbarui menjadi: " . ucfirst($status));
}



}
