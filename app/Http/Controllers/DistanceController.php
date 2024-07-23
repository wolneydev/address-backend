<?php

namespace App\Http\Controllers;

use App\Services\GoogleMapsApiService;
use Illuminate\Http\Request;

class DistanceController extends Controller
{
    protected $googleMapsApiService;

    public function __construct(GoogleMapsApiService $googleMapsApiService)
    {
        $this->googleMapsApiService = $googleMapsApiService;
    }

    public function calculateDistance(Request $request)
    {
        $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string',
        ]);

        $origin = $request->input('origin');
        $destination = $request->input('destination');

        $distance = $this->googleMapsApiService->getDistance($origin, $destination);

        if ($distance !== null) {
            return response()->json(['distance' => $distance]);
        } else {
            return response()->json(['error' => 'Failed to retrieve distance'], 500);
        }
    }
}
