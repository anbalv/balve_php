<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Add this line

class ScreenshotController extends Controller
{
    public function save(Request $request)
    {
        try {
            if ($request->hasFile('screenshot')) {
                $file = $request->file('screenshot');
                $filename = 'screenshot_' . time() . '.png';

                // Speichere den Screenshot im Ordner "public/screenshots"
                $path = $file->storeAs('public/screenshots', $filename);

                return response()->json(['status' => 'success', 'path' => Storage::url($path)]);
            } else {
                return response()->json(['status' => 'error', 'message' => 'No screenshot found'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Fehler beim Speichern des Screenshots: ' . $e->getMessage()); // Using the imported Log facade
            return response()->json(['status' => 'error', 'message' => 'Fehler beim Speichern des Screenshots.'], 500);
        }
    }
}
