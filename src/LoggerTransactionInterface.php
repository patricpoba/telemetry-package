<?php

namespace Plentymarkets\Logger;

use Plentymarkets\Logger\Drivers\LogDriverInterface;
 
interface LoggerTransactionInterface
{

    public function startTransaction(string $transactionId, array $attributes = []): void ;
  
    public function commitTransaction(): void ;
}
