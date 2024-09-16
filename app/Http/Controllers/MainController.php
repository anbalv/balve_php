<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // Gibt die View "index" zurück, die in resources/views/index.blade.php liegt
        return view('index');
    }
}
