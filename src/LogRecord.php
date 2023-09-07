<?php
namespace Plentymarkets\Logger;

use Plentymarkets\Logger\Drivers\CLIDriver;
use Plentymarkets\Logger\Drivers\JSONFileDriver;
use Plentymarkets\Logger\Drivers\TextFileDriver;

class LogRecord
{
    public function __construct(
        protected string $timestamp,
        protected string $level,
        protected string $message,
        protected array $meta = []
    ) {
    }


    public function getTimestamp() : string
    {
        return $this->timestamp;
    }


    public function getLevel() : string
    {
        return $this->level;
    }


    public function getMessage() : string
    {
        return $this->message;
    }


    public function getMeta() : array
    {
        return $this->meta;
    }


    public function toArray(): array
    {
        return [
            'timestamp' => $this->timestamp,
            'level'     => $this->level,
            'message'   => $this->message,
            'meta'      => $this->meta
        ];
    }

    public function __toString(): string
    {
        return "[{$this->timestamp}] {$this->level}: {$this->message}. Meta: ". implode(', ', $this->meta) . PHP_EOL ;
    }

    public function formatForDriver(string $logDriver) : string|array
    {
        return match ($logDriver) {
            JSONFileDriver::DRIVER_KEY  => $this->toArray(),
            TextFileDriver::DRIVER_KEY  => (string) $this,
            CLIDriver::DRIVER_KEY       => (string) $this,

            default => throw new \Exception("Unsupported Log Driver - {$logDriver}"),
        };
        

    }

}
