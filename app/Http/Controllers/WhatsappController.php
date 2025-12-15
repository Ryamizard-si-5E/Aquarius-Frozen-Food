<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Pelanggan;

class WhatsappController extends Controller
{
    public function user()
    {
        return view('wa-form'); // form untuk kirim pesan
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $pelanggan = Pelanggan::all();
        $gagal = [];

        foreach ($pelanggan as $p) {
            // === Normalisasi nomor HP ===
            $nomor = preg_replace('/\D/', '', $p->no_hp); // hapus non-digit

            if (substr($nomor, 0, 1) === '0') {
                $nomor = '62' . substr($nomor, 1);
            } elseif (substr($nomor, 0, 3) === '620') {
                $nomor = '62' . substr($nomor, 3);
            } elseif (substr($nomor, 0, 1) === '+') {
                $nomor = substr($nomor, 1);
            }

            try {
                // === Kirim ke Node.js API ===
                $response = Http::post('http://localhost:3000/send-message', [
                    'numbers' => [$nomor], // WAJS butuh array
                    'message' => $request->message
                ]);

                if ($response->failed()) {
                    $gagal[] = $p->no_hp . " (API tidak merespons)";
                    continue;
                }

                $result = $response->json();

                // === Cek hasil dari Node.js ===
                if (!isset($result['results'][0]['status']) || $result['results'][0]['status'] !== 'sent') {
                    $errorMsg = $result['results'][0]['error'] ?? 'gagal';
                    $gagal[] = $p->no_hp . " ($errorMsg)";
                }

            } catch (\Exception $e) {
                $gagal[] = $p->no_hp . " (Exception: " . $e->getMessage() . ")";
            }
        }

        // === Balikkan hasil ke view ===
        if (count($gagal) > 0) {
            return back()->with('error', 'Beberapa nomor gagal dikirimi: ' . implode(', ', $gagal));
        }

        return back()->with('success', 'Pesan berhasil dikirim ke semua pelanggan.');
    }
}
