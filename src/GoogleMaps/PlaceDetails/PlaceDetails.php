<?php

namespace Inventcorp\LaravelBasePackage\GoogleMaps\PlaceDetails;

class PlaceDetails
{
    private ?array $types;
    private string $placeId;
    private string $address;
    private float $latitude;
    private float $longitude;
    private string $postalCode;
    private string $postalCodeSuffix;
    private State $state;
    private Market $market;
    private County $county;

    public function __construct(array $details)
    {
        $this->types = $details['types'];
        $this->placeId = $details['place_id'];
        $this->address = $details['formatted_address'];
        $this->latitude = $details['geometry']['location']['lat'];
        $this->longitude = $details['geometry']['location']['lng'];

        foreach ($details['address_components'] as $component) {
            foreach ($component['types'] as $type) {
                if ($type === 'postal_code') {
                    $this->postalCode = $component['long_name'];
                    continue;
                }

                if ($type === 'postal_code_suffix') {
                    $this->postalCodeSuffix = $component['long_name'];
                    continue;
                }

                if ($type === 'administrative_area_level_2') {
                    $this->county = new County($component['short_name'], $component['long_name']);
                    continue;
                }

                if ($type === 'locality') {
                    $this->market = new Market($component['short_name'], $component['long_name']);
                    continue;
                }

                if ($type === 'administrative_area_level_1') {
                    $this->state = new State($component['short_name'], $component['long_name']);
                }
            }
        }
    }

    public function getZipCode(): string
    {
        return empty($this->postalCodeSuffix) ? $this->postalCode : "$this->postalCode-$this->postalCodeSuffix";
    }

    public function getTypes(): ?array
    {
        return $this->types;
    }

    public function getPlaceId(): string
    {
        return $this->placeId;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getState(): State
    {
        return $this->state;
    }

    public function getMarket(): Market
    {
        return $this->market;
    }

    public function getCounty(): County
    {
        return $this->county;
    }
}
