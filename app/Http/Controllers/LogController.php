<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log; // Import Log facade for debugging
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class LogController extends Controller
{
    public function showLogs($channel = 'daily') // Standard-Channel auf 'daily' gesetzt
    {
        // Setze das aktuelle Datum für die Anzeige in der Ansicht
        $logDate = Carbon::now()->format('d.m.Y H:i') . ' Uhr';

        // Setze den Pfad für die Log-Datei basierend auf dem Channel
        $logFile = storage_path("logs/{$channel}-" . Carbon::now()->format('Y-m-d') . ".json");

        // Logge den Pfad zur Datei zur Fehlerbehebung
        Log::info('Log file path: ' . $logFile);

        $logs = [];

        // Prüfe, ob die Log-Datei existiert
        if (File::exists($logFile)) {
            $fileContent = File::get($logFile);
            $logs = json_decode($fileContent, true) ?? [];

            // Limitiere die Anzahl der Logs auf 100, falls zu viele vorhanden sind
            $logs = array_slice($logs, 0, 100);
        } else {
            // Logge eine Warnung, wenn die Datei nicht existiert
            Log::warning('Log file does not exist: ' . $logFile);
        }

        // Paginieren der Logs
        $logs = $this->paginate($logs, 10)->withPath(route('logs.show', ['channel' => $channel]));

        // Rückgabe an die Blade-Ansicht mit den Log-Daten und dem aktuellen Datum
        return view('logs', compact('logs', 'channel', 'logDate'));
    }

    // Methode zur Paginierung der Logs
    protected function paginate(array $items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $items = Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
