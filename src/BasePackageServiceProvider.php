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
        $this->loadConfig();
        $this->bindInterfaces();
    }

    /**
     * @throws Exception
     */
    public function register()
    {
        $this->registerCloudLoggingFacade();
    }

    private function bindInterfaces(): void
    {
        foreach (config('base.interfacesBinding', []) as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    private function loadConfig(): void
    {
        $this->publishes(
            [
                __DIR__ . '/config/base.php' => config_path('base.php'),
            ],
            'config'
        );
    }

    private function registerCloudLoggingFacade(): void
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
