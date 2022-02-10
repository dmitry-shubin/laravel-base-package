<?php

namespace Inventcorp\LaravelBasePackage\Tools\Loggers;

use Exception;
use Inventcorp\LaravelBasePackage\Interfaces\IErrorLogger;

class NewRelicErrorLogger implements IErrorLogger
{
    public function logError(Exception $exception): void
    {
        if (app()->environment(['local', 'staging'])) {
            logger()->error($exception);
        }

        if (!app()->environment(['local'])) {
            $this->checkExtensionInstalled();
            newrelic_notice_error($exception);
        }
    }

    private function checkExtensionInstalled(): void
    {
        $message = 'NewRelic extension is not installed';
        if (!extension_loaded('newrelic')) {
            logger()->error($message);
            throw new Exception($message);
        }
    }
}
