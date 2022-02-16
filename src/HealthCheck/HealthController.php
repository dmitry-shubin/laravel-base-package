<?php

namespace Inventcorp\LaravelBasePackage\HealthCheck;

use Exception;
use Illuminate\Http\JsonResponse;
use Inventcorp\LaravelBasePackage\Http\AbstractBasePackageController;

class HealthController extends AbstractBasePackageController
{
    public function webCheck(): JsonResponse
    {
        return response()->json(['status' => 'OK']);
    }

    /**
     * Generates test exception.
     *
     * @throws Exception
     */
    public function throwException()
    {
        throw new Exception('Please ignore. This is test exception');
    }
}
