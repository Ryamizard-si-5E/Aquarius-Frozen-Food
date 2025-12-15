<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DistanceService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.ors.key');
    }

    public function getDistance($start, $end)
    {
        $url = "https://api.openrouteservice.org/v2/directions/driving-car";

        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->post($url, [
            'coordinates' => [
                $start, // [lng, lat]
                $end,   // [lng, lat]
            ],
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return [
                'distance' => $data['features'][0]['properties']['segments'][0]['distance'], // dalam meter
                'duration' => $data['features'][0]['properties']['segments'][0]['duration'], // dalam detik
            ];
        }

        return null;
    }
}
