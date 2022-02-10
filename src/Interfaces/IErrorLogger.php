<?php

namespace Inventcorp\LaravelBasePackage\Interfaces;

use Exception;

interface IErrorLogger
{
    public function logError(Exception $exception): void;
}
