<?php
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

return [
    'default_driver' => @$_ENV['LOG_DRIVER'],

    'drivers' => [

        'text' => [
            'path' => dirname(__DIR__) . '/' . (@$_ENV['LOG_TEXT_PATH'] ?? 'logs/text-log.txt'), 
        ],

        'json' => [ 
            'path' => dirname(__DIR__) . '/' . (@$_ENV['LOG_JSON_PATH'] ?? 'logs/json-log.json'), 
        ],

        'cli' => [ ],
    ],
];