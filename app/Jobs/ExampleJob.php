<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExampleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Daten, die der Job verarbeiten soll.
     *
     * @var mixed
     */
    protected $data;

    /**
     * Erstelle eine neue Job-Instanz.
     *
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Führe den Job aus.
     *
     * @return void
     */
    public function handle()
    {
        // Setze den Kontext für das Logging
        Log::withContext([
            'job_name' => self::class,
            'queue_name' => $this->queue ?? 'default',
        ]);

        // Starte das Logging des Jobs
        Log::info('Job execution started.', ['data' => $this->data]);

        try {
            // Hier kannst du die Hauptlogik deines Jobs einfügen
            $this->processData($this->data);

            // Erfolgsmeldung nach Abschluss der Job-Logik
            Log::info('Job execution completed successfully.');
        } catch (\Exception $e) {
            // Fehlerbehandlung und Logging
            Log::error('Job execution failed.', [
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
                'exception_code' => $e->getCode(),
            ]);
        }
    }

    /**
     * Beispielmethode zum Verarbeiten der Daten.
     *
     * @param mixed $data
     * @return void
     */
    protected function processData($data)
    {
        // Füge hier die Logik hinzu, die der Job ausführen soll
        // Beispielsweise könnte hier ein API-Aufruf oder eine Datenverarbeitung stattfinden
        Log::info('Processing data...', ['data' => $data]);

        // Dummy-Logik (z.B. Datenverarbeitung)
        sleep(2); // Simuliert eine Verzögerung oder längere Verarbeitung

        // Log nach der Datenverarbeitung
        Log::info('Data processed.', ['data' => $data]);
    }
}
