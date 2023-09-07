<?php

namespace Plentymarkets\Logger\Drivers;

use Plentymarkets\Logger\LogRecord;

interface LogDriverInterface
{
    /**
     * PHP versions prior 8.1 does not allow overriding of constants
     * This constant should be defined by all implementing classes
     */
    // const DRIVER_KEY = 'cli';

    /**
     * Process a single log entries at once.
     *
     * @param array<LogRecord> $records The records to handle
     */
    public function handle(LogRecord $record): bool;

    /**
     * Process a set of log entries at once.
     *
     * @param array<LogRecord> $records The records to handle
     */
    public function handleTransaction(string $transactionId, array $records, array $transactionAttributes = []): void;
}
