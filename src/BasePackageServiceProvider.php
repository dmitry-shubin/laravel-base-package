<?php

namespace Inventcorp\LaravelBasePackage;

use Exception;
use Google\Cloud\Logging\LoggingClient;
use Illuminate\Support\ServiceProvider;
use Inventcorp\LaravelBasePackage\GoogleCloudLogging\Logging\GoogleCloudLoggingService;

class BasePackageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/config/base.php' => config_path('base.php'),
            ],
            'config'
        );
    }

    public function register()
    {
        $this->app->bind('google-cloud-logger', function () {
            if (is_null(config('base.projectKey'))) {
                throw new Exception('Current google cloud project key is not present in .env');
            }
            if (is_null(config('base.projectId'))) {
                throw new Exception('Current google cloud project id is not present in .env');
            }

            $client = new LoggingClient(['projectId' => config('app.project_id')]);
            return new GoogleCloudLoggingService($client);
        });
    }
}
