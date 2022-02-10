<?php

namespace Inventcorp\LaravelBasePackage\GoogleCloudLogging\Logging;

use Monolog\Handler\AbstractProcessingHandler;

class GoogleCloudLoggerHandler extends AbstractProcessingHandler
{
    protected function write(array $record): void
    {
        GoogleCloudLoggingService::log(
            array_intersect_key($record, array_flip(['message', 'context', 'formatted'])),
            $record['level']
        )->send();
    }
}
