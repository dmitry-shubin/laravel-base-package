<?php

namespace Inventcorp\LaravelBasePackage\GoogleMaps\Service;

use Google\ApiCore\ApiException;
use GuzzleHttp\Client;
use Inventcorp\LaravelBasePackage\GoogleMaps\GeoCode\GoogleGeoCode;
use Inventcorp\LaravelBasePackage\GoogleMaps\GooglePlace\GooglePlace;
use Inventcorp\LaravelBasePackage\GoogleMaps\Interfaces\IGoogleMapsSession;
use Inventcorp\LaravelBasePackage\GoogleMaps\PlaceDetails\PlaceDetails;

class GoogleMapsService
{
    private Client $client;

    /**
     * @param string $toSearch
     * @return GooglePlace[]
     */
    public function getAddressAutocomplete(string $toSearch, IGoogleMapsSession $googleMapsSession): array
    {
        return $this->callApi(
            config('base.google_maps.route_autocomplete'),
            ['input' => $toSearch, 'sessiontoken' => $googleMapsSession->getToken()],
            fn (array $content) => array_map(
                fn (array $item) => new GooglePlace($item['place_id'], $item['description']),
                $content['predictions']['data']
            )
        );
    }

    public function getAddressDetails(string $placeId, IGoogleMapsSession $googleMapsSession): ?PlaceDetails
    {
        $googleMapsSession->destroyToken();

        return self::callApi(
            config('base.google_maps.route_details'),
            ['place_id' => $placeId],
            fn ($info) => empty($info['result']) ? new PlaceDetails($info['result']) : null
        );
    }

    /**
     * @param string $toSearch
     * @return GoogleGeoCode[]
     * @throws ApiException
     */
    public function getGeocode(string $toSearch): array
    {
        return $this->callApi(
            config('base.google_maps.route_geocode'),
            ['address' => $toSearch],
            fn ($result) => array_map(
                fn ($item) => new GoogleGeoCode($item['place_id'], $item['lat'], $item['lat'], $item['address']),
                $result
            )
        );
    }

    public function getClient(): Client
    {
        if (!isset($this->client)) {
            $this->client = new Client();
        }

        return $this->client;
    }

    private function callApi(
        string $url,
        array $params,
        callable $callback
    ) {
        $data = json_decode(
            $this->getClient()
                ->get($url, ['query' => $this->addDefaultConfig($params)])
                ->getBody()
                ->getContents(),
            true
        );

        if ($data['status'] === 'OK' || $data['status'] === 'ZERO_RESULTS') {
            return $callback($data);
        }

        $codes = [
            'INVALID_REQUEST' => 400,
            'OVER_QUERY_LIMIT' => 402,
            'REQUEST_DENIED' => 403,
            'NOT_FOUND' => 404,
            'UNKNOWN_ERROR' => 500,
        ];

        throw new ApiException('Error in call google maps api', $codes[$data['status']], $data['status']);
    }

    public function getMapsApiKey(): string
    {
        return config('base.google_maps.api_key');
    }

    public function getMapsApiKeyRestricted(): string
    {
        return config('base.google_maps.api_key_restricted');
    }

    private function addDefaultConfig(array $params): array
    {
        $params['key'] = $this->getMapsApiKey();
        $params['components'] = 'country:us';

        return $params;
    }
}
