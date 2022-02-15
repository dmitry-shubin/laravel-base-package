<?php

namespace Inventcorp\LaravelBasePackage\GoogleMaps\PlaceDetails;

abstract class AAddressComponent
{
    private string $shortName;
    private string $longName;

    public function __construct(string $shortName, string $longName)
    {
        $this->shortName = $shortName;
        $this->longName = $longName;
    }

    /**
     * @return string
     */
    public function getLongName(): string
    {
        return $this->longName;
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }
}
