<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Detail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());
        $bulan   = $request->input('bulan', Carbon::now()->format('Y-m'));

        // === PENJUALAN PER HARI ===
        $penjualanPerHari = Transaksi::whereDate('tanggal', $tanggal)
            ->where('status', 'diterima')
            ->sum('total_barang');

        // === PENJUALAN PER BULAN ===
        $penjualanPerBulan = Transaksi::whereMonth('tanggal', Carbon::parse($bulan)->month)
            ->whereYear('tanggal', Carbon::parse($bulan)->year)
            ->where('status', 'diterima')
            ->sum('total_barang');

        // === PRODUK TERJUAL ===
        $produkTerjual = Detail::select('id_barang', DB::raw('SUM(jumlah_barang) as total_terjual'))
            ->groupBy('id_barang')
            ->orderByDesc('total_terjual')
            ->with('barang')
            ->get();

        $produkTerlaris = $produkTerjual->first();
        $produkTersepi  = $produkTerjual->last();

        // === TRANSAKSI PER HARI ===
        $transaksiPerHari = Detail::whereHas('transaksi', function($q) use ($tanggal) {
                $q->whereDate('tanggal', $tanggal)->where('status', 'diterima');
            })
            ->whereHas('barang')
            ->with(['barang', 'transaksi.pelanggan'])
            ->get();

        // === TRANSAKSI PER BULAN ===
        $transaksiPerBulan = Detail::whereHas('transaksi', function($q) use ($bulan) {
                $q->whereMonth('tanggal', Carbon::parse($bulan)->month)
                  ->whereYear('tanggal', Carbon::parse($bulan)->year)
                  ->where('status', 'diterima');
            })
            ->whereHas('barang')
            ->with(['barang', 'transaksi.pelanggan'])
            ->get();

        return view('laporan-penjualan', compact(
            'tanggal',
            'bulan',
            'penjualanPerHari',
            'penjualanPerBulan',
            'produkTerlaris',
            'produkTersepi',
            'produkTerjual',
            'transaksiPerHari',
            'transaksiPerBulan'
        ));
    }

    public function downloadLaporan(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());
        $bulan   = $request->input('bulan', Carbon::now()->format('Y-m'));

        // Query sama seperti index()
        $penjualanPerHari = Transaksi::whereDate('tanggal', $tanggal)
            ->where('status', 'diterima')
            ->sum('total_barang');

        $penjualanPerBulan = Transaksi::whereMonth('tanggal', Carbon::parse($bulan)->month)
            ->whereYear('tanggal', Carbon::parse($bulan)->year)
            ->where('status', 'diterima')
            ->sum('total_barang');

        $produkTerjual = Detail::select('id_barang', DB::raw('SUM(jumlah_barang) as total_terjual'))
            ->groupBy('id_barang')
            ->orderByDesc('total_terjual')
            ->with('barang')
            ->get();

        $produkTerlaris = $produkTerjual->first();
        $produkTersepi  = $produkTerjual->last();

        $transaksiPerHari = Detail::whereHas('transaksi', function($q) use ($tanggal) {
                $q->whereDate('tanggal', $tanggal)->where('status', 'diterima');
            })
            ->whereHas('barang')
            ->with(['barang', 'transaksi.pelanggan'])
            ->get();

        $transaksiPerBulan = Detail::whereHas('transaksi', function($q) use ($bulan) {
                $q->whereMonth('tanggal', Carbon::parse($bulan)->month)
                  ->whereYear('tanggal', Carbon::parse($bulan)->year)
                  ->where('status', 'diterima');
            })
            ->whereHas('barang')
            ->with(['barang', 'transaksi.pelanggan'])
            ->get();

        // Render ke PDF
        $pdf = Pdf::loadView('laporan_penjualan_pdf', compact(
            'tanggal',
            'bulan',
            'penjualanPerHari',
            'penjualanPerBulan',
            'produkTerlaris',
            'produkTersepi',
            'produkTerjual',
            'transaksiPerHari',
            'transaksiPerBulan'
        ));

        return $pdf->setPaper('A4', 'portrait')
           ->download("Laporan-Penjualan-$tanggal.pdf");
    }
}
