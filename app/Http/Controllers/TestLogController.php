<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TestLogController extends Controller
{
    public function createTestLog()
    {
        // Beispiel-Logeintrag im Kanal 'testlog'
        $headers = request()->headers->all();
        unset($headers['cookie']);  // Entferne die Cookies aus dem Header

        Log::channel('testlog')->info('This is a test log entry', [
            'session_id' => Session::getId(),
            'session_data' => Session::all(),
            'headers' => $headers,  // Cookies entfernt
            'cookies' => request()->cookies->all()  // Nur relevante Cookies anzeigen
        ]);

        // Simuliere Job-Informationen und DB-Queries
        DB::listen(function ($query) {
            Log::channel('testlog')->info('Database Query', [
                'queries' => [
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'time' => $query->time
                ]
            ]);
        });

        // Ein zusätzlicher Log-Eintrag auf Fehler-Level mit Exception-Daten
        try {
            throw new \Exception('Test Exception Message');
        } catch (\Exception $e) {
            Log::channel('testlog')->error('This is a test error log entry', [
                'exception_message' => $e->getMessage(),
                'exception_trace' => $e->getTraceAsString(),
                'exception_code' => $e->getCode(),
                'session_id' => Session::getId(),
                'session_data' => Session::all(),
                'headers' => $headers,  // Cookies entfernt
                'cookies' => request()->cookies->all(),  // Nur relevante Cookies anzeigen
                'job_name' => 'ExampleJob',
                'queue_name' => 'default',
                'queries' => [
                    'query' => 'SELECT * FROM users WHERE id = ?',
                    'bindings' => [1],
                    'time' => 1.23
                ],
            ]);
        }

        return response()->json(['message' => 'Test logs have been written to the testlog channel']);
    }
}
