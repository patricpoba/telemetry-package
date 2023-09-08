<?php

namespace Plentymarkets\Logger\Tests\Drivers;

use PHPUnit\Framework\TestCase;
use Plentymarkets\Logger\Drivers\CLIDriver;
use Plentymarkets\Logger\LogLevel;
use Plentymarkets\Logger\LogRecord;

class CLIDriverTest extends TestCase
{
    public function testLogIsWrittenToCli()
    {
        $timestamp  = date("Y-m-d H:i:s A");
        $level      = LogLevel::DEBUG;
        $message    = "some log message here";
        $meta       = ['origin' => 'http', 'customerId' => '123'];

        $log = new LogRecord($timestamp, $level, $message, $meta);

        // Capture the output of echo
        ob_start();

        $cliDriver = new CLIDriver();
        $cliDriver->handle($log);

        // Get the output from echo
        $output = ob_get_clean();

        // Assert that the output contains the log message and tags
        $this->assertStringContainsString(print_r($log->toArray()), $output);
    }
}
