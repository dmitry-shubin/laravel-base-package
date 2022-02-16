<?php

namespace Inventcorp\LaravelBasePackage\Tools;

use Inventcorp\LaravelBasePackage\GoogleMaps\Interfaces\IGoogleMapsSession;

class GoogleMapsSession implements IGoogleMapsSession
{
    public function getToken(): string
    {
        return 'token';
    }

    public function destroyToken(): void
    {
        // TODO: Implement destroyToken() method.
    }
}
