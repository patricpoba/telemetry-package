<?php

namespace Plentymarkets\Logger\Drivers;

use Exception;
use Plentymarkets\Logger\LogRecord;

class JSONFileDriver extends CLIDriver
{
    const DRIVER_KEY = 'json';

    protected $filePath;

    protected $fileHandle;

    public function __construct(?string $filePath = null)
    {
        $this->filePath = $filePath
            ?? config()['drivers'][static::DRIVER_KEY]['path'];

        // create file if it does not exist
        $directory = dirname($this->filePath);

        // Create the directory (including parent directories if needed)
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (!file_exists($this->filePath)) {
            touch($this->filePath);
        }
    }
 

    protected function write(string|array $logRecordArray) : bool
    {
        $logRecords = file_get_contents($this->filePath);
        $logRecordsData = json_decode($logRecords, true);
        $logRecordsData[] = $logRecordArray;

        // Open the file for appending
        $this->fileHandle = fopen($this->filePath, 'w');

        if ($this->fileHandle === false) {
            throw new Exception("Failed to open JSON file for writing: $this->filePath");
        }
    
        $logJson = json_encode($logRecordsData, JSON_PRETTY_PRINT);

        if ($logJson === false) {
            throw new Exception("Failed to encode log entry as JSON.");
        }

        // Write the JSON log entry to the file
        if (fwrite($this->fileHandle, $logJson . PHP_EOL) === false) {
            throw new Exception("Failed to write log entry to JSON file.");
        }

        // Close the file handle
        fclose($this->fileHandle);

        return true;
    }

}
