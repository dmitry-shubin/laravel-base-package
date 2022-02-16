<?php

namespace Inventcorp\LaravelBasePackage\GoogleMaps\Interfaces;

interface IGoogleMapsSession
{
    public function getToken(): string;
    public function destroyToken(): void;
}
