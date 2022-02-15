<?php


return [
    'projectId' => env('GCLOUD_PROJECT_ID'),
    'projectKey' => env('GOOGLE_APPLICATION_CREDENTIALS'),
    'interfacesBinding' => [
        \Inventcorp\LaravelBasePackage\Interfaces\IErrorLogger::class =>
            \Inventcorp\LaravelBasePackage\Tools\Loggers\NewRelicErrorLogger::class
    ],

    'google_maps' => [
        'api_key' => env('GOOGLE_MAPS_API_KEY'),
        'api_key_restricted' => env('GOOGLE_MAPS_API_RESTRICTED'),
        'route_autocomplete' => 'https://maps.googleapis.com/maps/api/place/autocomplete/json',
        'route_details' => 'https://maps.googleapis.com/maps/api/place/details/json',
        'route_details' => 'https://maps.googleapis.com/maps/api/geocode/json',
    ],
];
