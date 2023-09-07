<?php

namespace Plentymarkets\Logger\Drivers;

use Exception;
use Plentymarkets\Logger\LogRecord;

class TextFileDriver extends JSONFileDriver
{
    const DRIVER_KEY = 'text';

    
    public function handle(LogRecord $logRecord): bool
    {
        $this->write((string) $logRecord);

        return true;
    }

    protected function write(array|string $logRecord): bool
    {
        // Open the file for appending
        $this->fileHandle = fopen($this->filePath, 'a');

        if ($this->fileHandle === false) {
            throw new Exception("Failed to open file for writing: $this->filePath");
        }

        // Append the log entry to the file;
        if (fwrite($this->fileHandle, $logRecord . PHP_EOL) === false) {
            throw new Exception("Failed to append log entry to log file.");
        }

        // Close the file handle
        fclose($this->fileHandle);

        return true;
    }

    public function handleTransaction(
        string $transactionId,
        array $records,
        array $transactionAttributes = []
    ): void {

        $log  = "TRANSACTION: {$transactionId}" . PHP_EOL;
        $log .= "TRANSACTION ATTRIBUTES: " . json_encode($transactionAttributes) . PHP_EOL;
        $log .= "TRANSACTION LOGS: " . PHP_EOL;
        // $log .= $records;

        foreach ($records as $record) {
            $log .= '[TXN_LOG]:' . $record;
        }

        $this->write($log);
    }
}
