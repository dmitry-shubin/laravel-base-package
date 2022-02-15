<?php

namespace Inventcorp\LaravelBasePackage\GoogleMaps;

use Illuminate\Support\Facades\Facade;

class GoogleMaps extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'google-maps';
    }
}

