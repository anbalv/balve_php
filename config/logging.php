<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\PsrLogMessageProcessor;
use Monolog\Processor\IntrospectionProcessor;
use App\Logging\CustomJsonFormatter;  // Importiere den Custom Formatter
use App\Logging\CustomLogger; // Importiere den Custom Logger

return [

    'default' => env('LOG_CHANNEL', 'daily'),

    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
        'trace' => env('LOG_DEPRECATIONS_TRACE', false),
    ],

    'channels' => [

        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily', 'single', 'testlog', 'critical'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'custom',
            'via' => App\Logging\CustomLogger::class,
            'level' => env('LOG_LEVEL', 'debug'),
            'name' => 'single', // Channel Name für dynamischen Dateinamen
        ],

        'daily' => [
            'driver' => 'custom',
            'via' => App\Logging\CustomLogger::class,
            'level' => env('LOG_LEVEL', 'debug'),
            'name' => 'daily', // Channel Name für dynamischen Dateinamen
        ],

        'critical' => [
            'driver' => 'custom',
            'via' => App\Logging\CustomLogger::class,
            'level' => 'critical',
            'name' => 'critical', // Channel Name für dynamischen Dateinamen
        ],

        'console' => [
            'driver' => 'monolog',
            'level' => 'debug',
            'handler' => StreamHandler::class,
            'formatter' => CustomJsonFormatter::class,  // JSON-Format für Konsolenlogs
            'with' => [
                'stream' => 'php://stdout',
            ],
            'processors' => [PsrLogMessageProcessor::class],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => 'error',
            'handler' => StreamHandler::class,
            'formatter' => CustomJsonFormatter::class,  // JSON-Format für Fehlerlogs
            'with' => [
                'stream' => 'php://stderr',
            ],
            'processors' => [PsrLogMessageProcessor::class],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
            'facility' => env('LOG_SYSLOG_FACILITY', LOG_USER),
            'replace_placeholders' => true,
            'processors' => [PsrLogMessageProcessor::class],
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
            'processors' => [PsrLogMessageProcessor::class],
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

        'testlog' => [
            'driver' => 'custom',
            'via' => App\Logging\CustomLogger::class,
            'level' => 'debug',
            'name' => 'testlog', // Channel Name für dynamischen Dateinamen
        ],
    ],
];
