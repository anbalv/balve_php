<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CustomLogger
{
    public function __invoke(array $config)
    {
        $logger = new Logger($config['name'] ?? 'custom'); // Verwende den Channel-Namen

        // Verwende den Channel-Namen und das Datum für den Dateipfad
        $filePath = storage_path('logs/' . ($config['name'] ?? 'log') . '-' . date('Y-m-d') . '.json');

        // Log-Level aus der Konfiguration entnehmen
        $logLevel = Logger::toMonologLevel($config['level'] ?? 'debug');

        // Erstelle den StreamHandler für die Log-Datei
        $handler = new StreamHandler($filePath, $logLevel);

        // Füge den CustomJsonFormatter hinzu
        $handler->setFormatter(new CustomJsonFormatter());

        // Füge den Handler dem Logger hinzu
        $logger->pushHandler($handler);

        // Debug-Ausgabe
        error_log("CustomLogger for channel '{$config['name']}' is being used. Log file path: {$filePath}");

        return $logger;
    }
}
