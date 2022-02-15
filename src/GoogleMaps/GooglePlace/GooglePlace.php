<?php

namespace Inventcorp\LaravelBasePackage\GoogleMaps\GooglePlace;

class GooglePlace
{
    private string $placeId;
    private string $description;

    public function __construct(string $placeId, string $description)
    {
        $this->placeId = $placeId;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getPlaceId(): string
    {
        return $this->placeId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
