<?php

namespace Inventcorp\LaravelBasePackage;

use Exception;
use Google\Cloud\Logging\LoggingClient;
use Illuminate\Support\ServiceProvider;
use Inventcorp\LaravelBasePackage\GoogleCloudLogging\Logging\GoogleCloudLoggingService;
use Inventcorp\LaravelBasePackage\Helpers\AppHelper;

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
        $this->app->bind('google-cloud-logger', fn () => new GoogleCloudLoggingService(
            new LoggingClient(['projectId' => AppHelper::getProjectId()])
        ));

        $this->app->bind('google-cloud-secret-manager', function () {
            $client = new LoggingClient(['projectId' => AppHelper::getProjectId()]);
            return new GoogleCloudLoggingService($client);
        });
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
}
