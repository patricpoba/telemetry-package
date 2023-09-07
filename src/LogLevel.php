<?php

namespace Plentymarkets\Logger;

/**
 * Log levels available
 */
class LogLevel
{
    const DEBUG   = 'DEBUG';

    const INFO    = 'INFO';

    const WARNING = 'WARNING';

    const ERROR   = 'ERROR';

    /**
     * Get all allowed log levels.
     */
    public static function all() : array
    {
        return [
            static::DEBUG,
            static::INFO,
            static::WARNING,
            static::ERROR
        ];
    }

}
