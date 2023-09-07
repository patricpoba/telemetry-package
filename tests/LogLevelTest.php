<?php

namespace Plentymarkets\Logger\Tests;

use PHPUnit\Framework\TestCase;
use Plentymarkets\Logger\LogLevel;

class LogLevelTest extends TestCase
{
    public function testConstants()
    {
        $this->assertSame(LogLevel::INFO, 'INFO');
        $this->assertSame(LogLevel::ERROR, 'ERROR');
        $this->assertSame(LogLevel::DEBUG, 'DEBUG');
        $this->assertSame(LogLevel::WARNING, 'WARNING');
    }

    public function testAllDriverAreReturnedInArray()
    {
        $actual = ['DEBUG', 'INFO','WARNING',  'ERROR' ];

        $this->assertSame(LogLevel::all(), $actual);
    }


}
