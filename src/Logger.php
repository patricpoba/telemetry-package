<?php

namespace Plentymarkets\Logger;

use InvalidArgumentException;
use Plentymarkets\Logger\LoggerInterface;
use Plentymarkets\Logger\Drivers\CLIDriver;
use Plentymarkets\Logger\Drivers\JSONFileDriver;
use Plentymarkets\Logger\Drivers\TextFileDriver;
use Plentymarkets\Logger\Drivers\LogDriverInterface;

class Logger implements LoggerInterface, LoggerTransactionInterface
{
    protected LogDriverInterface $driver;

    protected ?string $transactionId = null;

    protected array $transactionAttributes;

    protected array $transactionData;


    public function __construct(string|LogDriverInterface $driver)
    {
        $this->driver = ($driver instanceof LogDriverInterface)
                            ? $driver
                            : $this->getDriverByKey($driver);
    }


    /** @inheritDoc */
    public function getDriver() : LogDriverInterface
    {
        return $this->driver;
    }


    /**
     * Get an instance of a log driver using the driver name (key)
     * @throws \Exception
     */
    protected function getDriverByKey(string $driverKey) : LogDriverInterface
    {
        return match ($driverKey) {
            JSONFileDriver::DRIVER_KEY  => new JSONFileDriver,
            TextFileDriver::DRIVER_KEY  => new TextFileDriver,
            CLIDriver::DRIVER_KEY       => new CLIDriver,

            default => throw new InvalidArgumentException("Unsupported Log Driver - {$driverKey}"),
        };
    }


    protected function handleLog(string $level, string $message, array $meta = [])
    {
        if (!in_array($level, LogLevel::all())) {
            throw new InvalidArgumentException("Log level {$level} must be one of - " . implode(', ', LogLevel::all()));
        }

        $logRecord = new LogRecord(date("Y-m-d H:i:s A"), $level, $message, $meta);
 
        /**
         * If $this->transactionId is null, write log but if it's not null then the $logRecord
         * is part of a transaction hence add to $this->transactionData array to be
         * processed later when the transaction is commited.
         */
        isset($this->transactionId)
            ? $this->transactionData[] = $logRecord->formatForDriver($this->driver::DRIVER_KEY)
            : $this->driver->handle($logRecord);
    }


    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     */
    public function error(string $message, array $meta = []): void
    {
        $this->handleLog(LogLevel::ERROR, $message, $meta);
    }

    /**
     * Log Exceptional occurrences that are not errors.
     */
    public function warning(string $message, array $meta = []): void
    {
        $this->handleLog(LogLevel::WARNING, $message, $meta);
    }

    /**
     * Log information text
     */
    public function info(string $message, array $meta = []): void
    {
        $this->handleLog(LogLevel::INFO, $message, $meta);
    }

    /**
     * Detailed debug information.
     */
    public function debug(string $message, array $meta = []): void
    {
        $this->handleLog(LogLevel::DEBUG, $message, $meta);
    }

    /**
     * Logs with an arbitrary level.
     */
    public function log(string $level, string $message, array $meta = []): void
    {
        $this->handleLog($level, $message, $meta);
    }


    public function startTransaction(string $transactionId, array $attributes = []) : void
    {
        $this->transactionId = $transactionId;
        $this->transactionAttributes = $attributes;
    }

    
    public function commitTransaction() : void
    {
        $this->driver->handleTransaction(
            $this->transactionId,
            $this->transactionData,
            $this->transactionAttributes,
        );
        
        /** Reset attributes to indicated end of transaction */
        $this->transactionId = null;
        $this->transactionAttributes = [];
        $this->transactionData = [];
    }

}
