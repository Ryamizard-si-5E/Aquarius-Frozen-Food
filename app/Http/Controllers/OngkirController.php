<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DistanceService;

class OngkirController extends Controller
{
    protected $distanceService;

    public function __construct(DistanceService $distanceService)
    {
        $this->distanceService = $distanceService;
    }

    public function index()
    {
        return view('ongkir.index');
    }

    public function hitung(Request $request)
    {
        $origin = [
            'lat' => -6.200000, // contoh: Jakarta
            'lng' => 106.816666,
        ];

        $destination = [
            'lat' => $request->lat,
            'lng' => $request->lng,
        ];

        $result = $this->distanceService->getDistance($origin, $destination);

        if ($result) {
            // logika ongkir sederhana
            $ongkir = 0;
            if ($result['distance'] <= 4) {
                $ongkir = 5000;
            } elseif ($result['distance'] <= 6) {
                $ongkir = 10000;
            } else {
                $ongkir = 15000;
            }

            return back()->with('hasil', [
                'distance' => $result['distance'],
                'duration' => $result['duration'],
                'ongkir'   => $ongkir,
            ]);
        }

        return back()->with('error', 'Gagal menghitung jarak, coba lagi!');
    }
}
