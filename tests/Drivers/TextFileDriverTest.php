<?php

namespace Plentymarkets\Logger\Tests\Drivers;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Plentymarkets\Logger\Logger;
use Plentymarkets\Logger\LogLevel;
use Plentymarkets\Logger\LogRecord;
use Plentymarkets\Logger\Drivers\CLIDriver;
use Plentymarkets\Logger\Drivers\JSONFileDriver;
use Plentymarkets\Logger\Drivers\TextFileDriver;

class TextFileDriverTest extends TestCase
{
    private string $testFilePath;

    protected function setUp() : void
    {
        // Create a temporary test file
        $this->testFilePath = tempnam(sys_get_temp_dir(), 'test_text_file');
    }

    protected function tearDown(): void
    {
        // Delete the test file
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
    }

    public function testLogIsWrittenToTextFile()
    {
        // Arrange
        $log = new LogRecord(
            date("Y-m-d H:i:s A"),
            LogLevel::INFO,
            "some log message here",
            ['origin' => 'webhook']
        );

        // Act
        $textFIleDriver = new TextFileDriver($this->testFilePath);
        $textFIleDriver->handle($log);

        // Assert
        $writtenContent = file_get_contents($this->testFilePath);
        
        $this->assertStringContainsString((string) $log, $writtenContent);
    }
}
