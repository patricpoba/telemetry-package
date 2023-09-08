<?php

namespace Plentymarkets\Logger\Tests\Drivers;

use PHPUnit\Framework\TestCase;
use Plentymarkets\Logger\LogLevel;
use Plentymarkets\Logger\LogRecord;
use Plentymarkets\Logger\Drivers\JSONFileDriver;

class JSONFileDriverTest extends TestCase
{
    private $testFilePath;

    protected function setUp(): void
    {
        // Create a temporary test file
        $this->testFilePath = tempnam(sys_get_temp_dir(), 'test_json_file');
    }



    protected function tearDown(): void
    {
        // Clean up the test file
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
    }

    public function testLogIsWrittenToJsonFile()
    {
        // Arrange
        // $log = new LogRecord(
        //     date("Y-m-d H:i:s A"),
        //     LogLevel::INFO,
        //     "some log message here",
        //     ['origin' => 'webhook']
        // );

        $timestamp  = date("Y-m-d H:i:s A");
        $level      = LogLevel::DEBUG;
        $message    = "json driver test log";
        $meta       = ['origin' => 'http', 'customerId' => '123'];

        $log = new LogRecord($timestamp, $level, $message, $meta);

        // Act
        $jsonFIleDriver = new JSONFileDriver($this->testFilePath);
        $jsonFIleDriver->handle($log);

        // Assert
        $writtenContent = file_get_contents($this->testFilePath);
        $decodedContent = json_decode($writtenContent, true);

        $this->assertNotEmpty($writtenContent);
        $this->assertNotNull($decodedContent);
        $this->assertArrayHasKey('meta', $decodedContent[0]);
        $this->assertArrayHasKey('level', $decodedContent[0]);
        $this->assertArrayHasKey('message', $decodedContent[0]);
        $this->assertArrayHasKey('timestamp', $decodedContent[0]);
    }
}
