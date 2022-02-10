<?php


return [
    'projectId' => env('GCLOUD_PROJECT_ID'),
    'projectKey' => env('GOOGLE_APPLICATION_CREDENTIALS'),
    'interfacesBinding' => [
        \Inventcorp\LaravelBasePackage\Interfaces\IErrorLogger::class =>
            \Inventcorp\LaravelBasePackage\Tools\Loggers\NewRelicErrorLogger::class
    ],
];
