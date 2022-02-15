<?php

namespace Inventcorp\LaravelBasePackage\Helpers;

use Exception;

class AppHelper
{
    public static function getProjectId(): string
    {
        if ($value = config('base.projectId')) {
            return $value;
        }

        throw new Exception('Current google cloud project id is not present in .env');
    }
}
