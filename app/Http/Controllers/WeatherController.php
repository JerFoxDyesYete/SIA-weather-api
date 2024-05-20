<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WeatherController extends Controller
{

    //GET CURRENT WEATHER via location parameter
    public function getCurrentWeather(Request $request): JsonResponse
    {
        $location = $request->input('location', 'Philippines'); // Default location if location is not provided
        $client = new Client();

        $host = env('RAPIDAPI_HOST');
        $apiKey = env('RAPIDAPI_KEY');

        try {
            $response = $client->request('GET', "https://{$host}/current.json?q={$location}", [
                'headers' => [
                    'X-RapidAPI-Host' => $host,
                    'X-RapidAPI-Key' => $apiKey,
                ],
            ]);

            return response()->json(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch weather data'], 500);
        }
    }

    //weather forecast specific location

    public function getForecast(Request $request)
    {
        $location = $request->input('location', 'Philippines'); //DEFAULT LOCATION IF LOCATION IS NOT PROVIDED
        $client = new Client();

        $host = env('RAPIDAPI_HOST');
        $apiKey = env('RAPIDAPI_KEY');

        try {
            $response = $client->request('GET', "https://{$host}/forecast.json?q={$location}&days=3", [
                'headers' => [
                    'X-RapidAPI-Host' => $host,
                    'X-RapidAPI-Key' => $apiKey,
                ],
            ]);

            return response()->json(json_decode($response->getBody(), true));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch weather data'], 500);
        }
    }

    // waether history

    public function getHistory(Request $request): JsonResponse
    {
        $location = $request->input('location', 'Philippines');
        $date = $request->input('date', ''); // data format YEAR-MONTH-DATE (2024-05-20)

        if (empty($date)) {
            return response()->json(['error' => 'Date is required. Format must be in YYYY-MM-DD'], 400);
        }

        $client = new Client();

        $host = env('RAPIDAPI_HOST');
        $apiKey = env('RAPIDAPI_KEY');

        try {
            $response = $client->request('GET', "https://{$host}/history.json", [
                'query' => [
                    'q' => $location,
                    'dt' => $date,
                    'lang' => 'en',
                ],
                'headers' => [
                    'X-RapidAPI-Host' => $host,
                    'X-RapidAPI-Key' => $apiKey,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
