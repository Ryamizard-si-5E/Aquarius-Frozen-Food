<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Keranjang;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\Detail;
use Illuminate\Support\Facades\Log;

class KeranjangController extends Controller
{
    /**
     * 📦 Tampilkan isi keranjang user
     */
    public function keranjang()
    {
        if (!Auth::guard('pelanggan')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $pelangganId = Auth::guard('pelanggan')->user()->id_pelanggan;

        $keranjang = Keranjang::where('id_pelanggan', $pelangganId)
            ->with('barang')
            ->get();

        $pesanPeringatan = [];

        foreach ($keranjang as $item) {
            $stok = $item->barang->stok ?? 0;

            if ($stok <= 0) {
                $pesanPeringatan[] = "Barang <strong>{$item->barang->nama_barang}</strong> sudah habis dan dihapus dari keranjang.";
                $item->delete();
                continue;
            }

            if ($item->quantity > $stok) {
                $pesanPeringatan[] = "Stok <strong>{$item->barang->nama_barang}</strong> hanya tersisa {$stok}, jumlah di keranjang disesuaikan.";
                $item->quantity = $stok;
                $item->save();
            }
        }

        $keranjang = Keranjang::where('id_pelanggan', $pelangganId)
            ->with('barang')
            ->get();

        $totalBarang = $keranjang->sum(fn($item) => ($item->barang->harga ?? 0) * $item->quantity);

        return view('keranjang', [
            'keranjang'    => $keranjang,
            'peringatan'   => $pesanPeringatan,
            'totalBarang'  => $totalBarang,
        ]);
    }

    /**
     * ➕ Tambahkan barang ke keranjang
     */
    public function add(Request $request, $id_barang)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);

        $barang = Barang::findOrFail($id_barang);

        $keranjang = Keranjang::where('id_pelanggan', Auth::guard('pelanggan')->user()->id_pelanggan)
            ->where('id_barang', $id_barang)
            ->first();

        $currentQty = $keranjang ? $keranjang->quantity : 0;
        $totalQty   = $currentQty + $request->jumlah;

        if ($totalQty > $barang->stok) {
            return back()->with('error', "Stok tidak mencukupi. Stok tersedia hanya {$barang->stok}.");
        }

        if ($keranjang) {
            $keranjang->quantity = $totalQty;
            $keranjang->save();
        } else {
            Keranjang::create([
                'id_pelanggan' => Auth::guard('pelanggan')->user()->id_pelanggan,
                'id_barang'    => $id_barang,
                'quantity'     => $request->jumlah
            ]);
        }

        return redirect()->route('keranjang.index')->with('success', 'Barang ditambahkan ke keranjang.');
    }

    /**
     * ❌ Hapus item dari keranjang
     */
    public function destroy($id)
    {
        if (!Auth::guard('pelanggan')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $item = Keranjang::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    /**
     * 🚚 Hitung jarak & ongkir (pakai map picker lat/lng)
     */
   public function hitungJarak(Request $request)
    {
        // terima input
        $latUser = $request->input('lat');
        $lonUser = $request->input('lon');
        $alamat  = $request->input('alamat') ?? $request->input('alamatt');
        $totalBarang = (float) ($request->input('total_barang') ?? 0);

        // lokasi toko — gunakan env jika mau supaya mudah diubah
        $latToko = (float) env('TOKO_LAT', 0.899338849382596);   // contoh: 0.8993
        $lonToko = (float) env('TOKO_LON', 108.98216977335917);  // contoh: 108.9821

        // kalau tidak dikirim lat/lon, coba geocoding alamat (LocationIQ)
        if (empty($latUser) || empty($lonUser)) {
            if (empty($alamat)) {
                return response()->json(['success'=>false, 'message'=>'Koordinat atau alamat tidak diberikan'], 400);
            }

            // LocationIQ geocoding
            $locationiqKey = env('LOCATIONIQ_KEY');
            if (!$locationiqKey) {
                return response()->json(['success'=>false, 'message'=>'LocationIQ key belum diset (fallback)'], 500);
            }

            $geoRes = Http::get('https://us1.locationiq.com/v1/search.php', [
                'key' => $locationiqKey,
                'q'   => $alamat,
                'format' => 'json',
                'limit' => 1,
                'countrycodes' => 'ID'
            ]);

            if ($geoRes->failed() || empty($geoRes->json()[0])) {
                return response()->json(['success'=>false, 'message'=>'Alamat tidak ditemukan oleh geocoder'], 404);
            }

            $geo = $geoRes->json()[0];
            $latUser = (float) $geo['lat'];
            $lonUser = (float) $geo['lon'];
        } else {
            $latUser = (float) $latUser;
            $lonUser = (float) $lonUser;
        }

        // 1) Coba ORS directions (rute jalan). ORS mengharapkan [lon, lat]
        $distanceMeters = null;
        $orsKey = env('ORS_API_KEY');

        if ($orsKey) {
            try {
                $orsUrl = 'https://api.openrouteservice.org/v2/directions/driving-car';
                $payload = ['coordinates' => [
                    [(float)$lonToko, (float)$latToko],
                    [(float)$lonUser,  (float)$latUser]
                ]];

                $orsRes = Http::withHeaders([
                    'Authorization' => $orsKey,
                    'Content-Type' => 'application/json'
                ])->post($orsUrl, $payload);

                if ($orsRes->successful()) {
                    $json = $orsRes->json();

                    // kemungkinan struktur: ['routes'][0]['summary']['distance']  atau feature-based
                    if (!empty($json['routes'][0]['summary']['distance'])) {
                        $distanceMeters = $json['routes'][0]['summary']['distance'];
                    } elseif (!empty($json['features'][0]['properties']['segments'][0]['distance'])) {
                        $distanceMeters = $json['features'][0]['properties']['segments'][0]['distance'];
                    } elseif (!empty($json['features'][0]['properties']['summary']['distance'])) {
                        $distanceMeters = $json['features'][0]['properties']['summary']['distance'];
                    }
                }
            } catch (\Exception $e) {
                // ORS gagal -> akan fallback ke haversine
            }
        }

        // fallback: haversine (garis lurus) kalau ORS tidak mengembalikan distance
        if (empty($distanceMeters)) {
            // haversine (meter)
            $R = 6371000;
            $dLat = deg2rad($latUser - $latToko);
            $dLon = deg2rad($lonUser - $lonToko);
            $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latToko)) * cos(deg2rad($latUser)) * sin($dLon/2) * sin($dLon/2);
            $c = 2 * atan2(sqrt($a), sqrt(1-$a));
            $distanceMeters = $R * $c;
        }

        $distanceKm = round($distanceMeters / 1000, 2);

        // Hitung ongkir sesuai aturan yang Anda minta
        $ongkir = 0;
        if ($totalBarang >= 50000) {
            if ($distanceKm <= 4) $ongkir = 0;
            elseif ($distanceKm > 4 && $distanceKm <= 6) $ongkir = 5000;
            else $ongkir = 10000;
        } else {
            if ($distanceKm <= 4) $ongkir = 5000;
            elseif ($distanceKm > 4 && $distanceKm <= 6) $ongkir = 10000;
            else $ongkir = 15000;
        }

        return response()->json([
            'success' => true,
            'jarak'   => $distanceKm,
            'ongkir'  => $ongkir,
            'lat'     => $latUser,
            'lon'     => $lonUser
        ]);
    }


    /**
     * 🛒 Proses checkout
     */
    public function checkout(Request $request)
    {
        if (!Auth::guard('pelanggan')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'metode_pengiriman' => 'required',
            'metode_pembayaran' => 'required',
            'bukti_pembayaran'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'alamatt'           => 'required|string|max:255',
            'total_barang'      => 'required|numeric',
            'ongkir'            => 'required|numeric',
            'total'             => 'required|numeric',
        ]);

        $pelangganId = Auth::guard('pelanggan')->user()->id_pelanggan;
        $keranjang   = Keranjang::where('id_pelanggan', $pelangganId)->with('barang')->get();

        if ($keranjang->isEmpty()) {
            return back()->with('error', 'Keranjang Anda masih kosong.');
        }

        foreach ($keranjang as $item) {
            if ($item->quantity > $item->barang->stok) {
                return back()->with('error', "Stok barang '{$item->barang->nama_barang}' tidak mencukupi.");
            }
        }

        $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        $idTransaksi = 'TRX' . time();

        $transaksi = Transaksi::create([
            'id_transaksi'      => $idTransaksi,
            'id_pelanggan'      => $pelangganId,
            'total_barang'      => $request->total_barang,
            'ongkir'            => $request->ongkir,
            'total_harga'       => $request->total,
            'alamatt'           => $request->alamatt,
            'metode_pengiriman' => $request->metode_pengiriman,
            'jarak'             => $request->jarak ?? null,
            'metode'            => $request->metode_pembayaran,
            'tanggal'           => now(),
            'bukti_pembayaran'  => $buktiPath
        ]);

        foreach ($keranjang as $item) {
            Detail::create([
                'id_transaksi'  => $idTransaksi,
                'id_barang'     => $item->id_barang,
                'jumlah_barang' => $item->quantity
            ]);

            $barang = Barang::find($item->id_barang);
            $barang->stok -= $item->quantity;
            $barang->save();
        }

        Keranjang::where('id_pelanggan', $pelangganId)->delete();

        return redirect()->route('dashboard')->with('success', 'Checkout berhasil! Menunggu konfirmasi admin.');
    }
}
