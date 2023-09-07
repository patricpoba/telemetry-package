<?php

namespace Plentymarkets\Logger;

use Plentymarkets\Logger\Drivers\LogDriverInterface;

/**
 * Define a logger instance.
 */
interface LoggerInterface
{
    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     */
    public function error(string $message, array $meta = []): void;

    /**
     * Exceptional occurrences that are not errors.
     */
    public function warning(string $message, array $meta = []): void;

    /**
     * Interesting events.
     */
    public function info(string $message, array $meta = []): void;

    /**
     * Detailed debug information.
     */
    public function debug(string $message, array $meta = []): void;

    /**
     * Logs with an arbitrary level.
     *
     * @throws \Psr\Log\InvalidArgumentException
     */
    public function log(string $level, string $message, array $meta = []): void;

    /**
     * Get current driver in use
     *
     * @return LogDriverInterface
     */
    public function getDriver() : LogDriverInterface ;

}
