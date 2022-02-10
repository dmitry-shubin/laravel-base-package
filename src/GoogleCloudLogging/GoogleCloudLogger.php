<?php

namespace Inventcorp\LaravelBasePackage\GoogleCloudLogging;

use Illuminate\Support\Facades\Facade;

class GoogleCloudLogger extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'google-cloud-logger';
    }
}
