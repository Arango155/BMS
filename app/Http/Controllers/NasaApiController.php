<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NasaApiController extends Controller
{
    public function getNasaData()
    {
        $apiKey = env('NASA_API_KEY');
        $url = "https://api.nasa.gov/planetary/apod?api_key={$apiKey}";

        $response = Http::get($url);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch NASA data'], 500);
        }

        return response()->json($response->json());
    }

}
