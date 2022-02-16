<?php

namespace Inventcorp\LaravelBasePackage\GoogleMaps\GeoCode;

use Illuminate\Contracts\Support\Arrayable;

class GoogleGeoCode implements Arrayable
{
    private string $placeId;
    private float $latitude;
    private float $longitude;
    private string $address;

    public function __construct(string $placeId, float $latitude, float $longitude, string $address)
    {
        $this->placeId = $placeId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPlaceId(): string
    {
        return $this->placeId;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    public function toArray(): array
    {
        return [
            'place_id' => $this->getPlaceId(),
            'address' => $this->getAddress(),
            'latitude' => $this->getLatitude(),
            'longitude' => $this->getLongitude(),
        ];
    }
}
