<?php

namespace Inventcorp\LaravelBasePackage\GoogleMaps\Interfaces;

interface IGoogleMapsSession
{
    public function createToken(): string;
    public function getToken(): string;
    public function destroyToken(): void;
}
