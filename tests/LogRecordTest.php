<?php

namespace Plentymarkets\Logger\Tests;

use PHPUnit\Framework\TestCase;
use Plentymarkets\Logger\LogLevel;
use Plentymarkets\Logger\LogRecord;

class LogRecordTest extends TestCase
{
    private $timestamp;
    private $level;
    private $message;
    private $meta;
    private $log;

    protected function setUp(): void
    {
        $this->timestamp = (new \Datetime)->format("Y-m-d H:i:s A");
        $this->level     = LogLevel::DEBUG;
        $this->message   = "some log message here";
        $this->meta      = ['origin' => 'http', 'customerId' => '123'];

        $this->log = new LogRecord($this->timestamp, $this->level, $this->message, $this->meta);
    }

    public function testConstructorAttributesAreAccessibleViaGetters()
    {
        $this->assertSame($this->timestamp, $this->log->getTimestamp());
        $this->assertSame($this->level, $this->log->getLevel());
        $this->assertSame($this->message, $this->log->getMessage());
        $this->assertSame($this->meta, $this->log->getMeta());
    }

    public function testToArray()
    {
        $expectedArray = [
            'timestamp' => $this->timestamp,
            'level'     => $this->level,
            'message'   => $this->message,
            'meta'      => $this->meta
        ];

        $this->assertSame($expectedArray, $this->log->toArray());
    }

    public function testToString()
    {
        $stringRepresentation =
        "[{$this->timestamp}] {$this->level}: {$this->message}. Meta: " . implode(', ', $this->meta) . PHP_EOL;

        $this->assertSame($stringRepresentation, (string) $this->log);
    }
}
