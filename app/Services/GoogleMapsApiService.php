<?php

namespace App\Services;

use GuzzleHttp\Client;

class GoogleMapsApiService
{
    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getDistance($origin, $destination)
    {
        $client = new Client();

        $response = $client->get(env('GOOGLE_MAPS_DISTANCES'), [
            'query' => [
                'key' => $this->apiKey,
                'origins' => $origin,
                'destinations' => $destination,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        // Verifica se a solicitação foi bem-sucedida e se há resultados válidos
        if ($response->getStatusCode() == 200 && isset($data['rows'][0]['elements'][0]['distance']['value'])) {
            // Retorna a distância em metros
            return $data['rows'][0]['elements'][0]['distance']['value'];
        }

        // Se algo der errado, retorna null ou lança uma exceção, dependendo dos requisitos
        return null;
    }

    public function getCoordinates($keyword)
    {
        $client = new Client();

        $response = $client->get(env('GOOGLE_MAPS_COORDINATES_TEXT'), [
            'query' => [
                'query' => $keyword,
                'key' => $this->apiKey,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        if (isset($data['results'][0]['geometry']['location'])) {
            return $data['results'][0]['geometry']['location'];
        }

        return null;
    }    
}
