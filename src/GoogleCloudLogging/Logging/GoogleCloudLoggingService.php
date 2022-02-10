<?php

namespace Inventcorp\LaravelBasePackage\GoogleCloudLogging\Logging;

use Google\Cloud\Logging\LoggingClient;
use InvalidArgumentException;

class GoogleCloudLoggingService
{
    public const EMERGENCY = 800;
    public const ALERT = 700;
    public const CRITICAL = 600;
    public const ERROR = 500;
    public const WARNING = 400;
    public const NOTICE = 300;
    public const INFO = 200;
    public const DEBUG = 100;

    private const LEVELS = [
        self::DEBUG     => 'DEBUG',
        self::INFO      => 'INFO',
        self::NOTICE    => 'NOTICE',
        self::WARNING   => 'WARNING',
        self::ERROR     => 'ERROR',
        self::CRITICAL  => 'CRITICAL',
        self::ALERT     => 'ALERT',
        self::EMERGENCY => 'EMERGENCY',
    ];

    private const LOG_LEVELS = [
        'DEBUG'     => self::DEBUG,
        'INFO'      => self::INFO,
        'NOTICE'    => self::NOTICE,
        'WARNING'   => self::WARNING,
        'ERROR'     => self::ERROR,
        'CRITICAL'  => self::CRITICAL,
        'ALERT'     => self::ALERT,
        'EMERGENCY' => self::EMERGENCY,
    ];

    private LoggingClient $loggingClient;
    private LogResource $logResource;
    private string $logName = 'app_log';
    private array $payload = [];
    private int $logLevel = self::DEBUG;

    public function __construct(LoggingClient $loggingClient)
    {
        $this->loggingClient = $loggingClient;
    }

    public static function log(array $payload = [], int $level = self::DEBUG): self
    {
        return app('google-cloud-logger')->setPayload($payload)->setLogLevel($level);
    }

    public function setLogName(string $logName): self
    {
        $this->logName = $logName;
        return $this;
    }

    private function getLogName(): string
    {
        return $this->logName;
    }

    private function getLogResource(): array
    {
        return isset($this->logResource) ? $this->logResource->toArray() : [];
    }

    private function getLogLevel(): int
    {
        return $this->logLevel;
    }

    private static function validateLogLevel(int $loglevel): void
    {
        if (!in_array($loglevel, self::LOG_LEVELS)) {
            throw new InvalidArgumentException('Unknown log level');
        }
    }

    public function setPayload(array $payload): self
    {
        $this->payload = $payload;
        return $this;
    }

    public function setLogLevel(int $logLevel): self
    {
        self::validateLogLevel($logLevel);
        $this->logLevel = $logLevel;
        return $this;
    }

    public function setLogResource(LogResource $logResource): self
    {
        $this->logResource = $logResource;
        return $this;
    }

    public function send(): bool
    {
        $logger = $this->loggingClient->logger($this->getLogName(), $this->getLogResource());
        $logger->write(
            $logger->entry($this->payload),
            ['severity' => $this->getLogLevel()]
        );

        return true;
    }
}
