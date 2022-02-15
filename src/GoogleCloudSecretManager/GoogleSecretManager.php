<?php

namespace Inventcorp\LaravelBasePackage\GoogleCloudSecretManager;

use Illuminate\Support\Facades\Facade;

class GoogleSecretManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'google-cloud-secret-manager';
    }
}
