<?php

namespace App\Logging;

use Monolog\Formatter\JsonFormatter;
use Monolog\LogRecord;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CustomJsonFormatter extends JsonFormatter
{
    protected static $logFilePath = null;

    public function __construct()
    {
        parent::__construct(JsonFormatter::BATCH_MODE_JSON, true); // prettyPrint = true
    }

    public function format(LogRecord $record): string
    {
        // Setze den Pfad zur Log-Datei dynamisch mit dem aktuellen Datum
        $date = now()->format('Y-m-d');
        self::$logFilePath = storage_path("logs/{$record->channel}-{$date}.json");

        // Formatieren des Log-Eintrags und hinzufügen von 'timestamp'
        $recordArray = $record->toArray();
        $recordArray['extra']['timestamp'] = now()->toDateTimeString();

        // Benutzerbezogene Informationen hinzufügen
        if (Auth::check()) {
            $user = Auth::user();
            $recordArray['extra']['user_id'] = $user->id;
            $recordArray['extra']['username'] = $user->name;
            $recordArray['extra']['role'] = $user->role;
        } else {
            $recordArray['extra']['user_id'] = 'guest';
            $recordArray['extra']['username'] = 'guest';
            $recordArray['extra']['role'] = 'guest';
        }

        // Request-Informationen immer hinzufügen
        $recordArray['extra']['url'] = request()->fullUrl();
        $recordArray['extra']['method'] = request()->method();
        $recordArray['extra']['request_id'] = request()->header('X-Request-ID', 'no-request-id');

        // Session-Informationen hinzufügen
        $recordArray['extra']['session_id'] = Session::getId();
        $recordArray['extra']['session_data'] = Session::all();
        $recordArray['extra']['headers'] = request()->headers->all();

        // **Hinzufügen der Cookies**, falls vorhanden
        $recordArray['extra']['cookies'] = request()->cookies->all();

        // Falls eine Exception existiert, füge Exception-Details hinzu
        if (isset($record->context['exception']) && $record->context['exception'] instanceof \Throwable) {
            $exception = $record->context['exception'];
            $recordArray['extra']['exception_message'] = $exception->getMessage();
            $recordArray['extra']['exception_trace'] = $exception->getTraceAsString();
            $recordArray['extra']['exception_code'] = $exception->getCode();
        } else {
            // Füge Standardwerte hinzu, falls keine Exception vorhanden ist
            $recordArray['extra']['exception_message'] = 'No exception message';
            $recordArray['extra']['exception_trace'] = 'No exception trace';
            $recordArray['extra']['exception_code'] = 0;
        }

        // Job-Informationen hinzufügen (wenn sie im Kontext vorhanden sind)
        $recordArray['extra']['job_name'] = $record->context['job_name'] ?? 'No job';
        $recordArray['extra']['queue_name'] = $record->context['queue_name'] ?? 'No queue';

        // Queries hinzufügen (falls sie im Kontext vorhanden sind)
        $recordArray['extra']['queries'] = $record->context['queries'] ?? 'No queries logged';
        
        // Berechne den log_number basierend auf der Anzahl der vorhandenen Logs
        $logs = [];
        if (File::exists(self::$logFilePath)) {
            $logs = json_decode(File::get(self::$logFilePath), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $logs = [];
            }
        }

        $logCount = count($logs) + 1;  // Startet bei 1, dann fortlaufend
        $recordArray['extra']['log_number'] = $logCount;

        // Füge den neuen Log-Eintrag hinzu und speichere ihn
        $logs[] = $recordArray;
        File::put(self::$logFilePath, json_encode($logs, JSON_PRETTY_PRINT));

        return '';
    }
}
