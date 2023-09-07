<?php

namespace Plentymarkets\Logger\Drivers;

use Plentymarkets\Logger\LogRecord;

class CLIDriver implements LogDriverInterface
{
    const DRIVER_KEY = 'cli';

    protected function write(array|string $logRecordArray): bool
    {
        print_r($logRecordArray);

        return true;
    }


    public function handle(LogRecord $logRecord): bool
    {
        $this->write($logRecord->toArray());

        return true;
    }

    
    public function handleTransaction(string $transactionId, array $records, array $transactionAttributes = []): void
    {
        $this->write([
            'transaction_ID' => $transactionId,
            'transaction_attributes' => $transactionAttributes,
            'logs' => $records
        ]);
    }

}
