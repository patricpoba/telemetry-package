<?php

namespace Plentymarkets\Logger\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Plentymarkets\Logger\Logger;
use Plentymarkets\Logger\Drivers\TextFileDriver;

class LoggerTest extends TestCase
{
    public function testGetDriver()
    {
        $logger = new Logger(TextFileDriver::DRIVER_KEY);
        
        $this->assertSame(TextFileDriver::class, get_class($logger->getDriver()));
    }

    public function testGetDriverByKeyThrowsExceptionWhenGivenWrongKey()
    {
        $this->expectException(InvalidArgumentException::class);

        new Logger('wrongKey');
    }


}
