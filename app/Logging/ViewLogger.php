<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ViewLogger
{
    public function __invoke(array $config)
    {
        $logger = new Logger('view');

        // Aktuelles Datum für die Log-Datei (z.B. 'laravel-2024-09-11.log')
        $logDate = date('Y-m-d');
        $logFile = storage_path("logs/laravel-$logDate.log");

        // Log in der richtigen Datei speichern
        $logger->pushHandler(new StreamHandler($logFile));

        return $logger;
    }
}
