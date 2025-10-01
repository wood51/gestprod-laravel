<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MachineDataController extends Controller
{
    public function store(Request $request)
    {
        // Pour debug : log toutes les données reçues
        Log::info('Données machine reçues', $request->all());

        // Ici tu pourrais valider et insérer selon ta BDD
        return response()->json(['status' => 'ok', 'message' => 'Données bien reçues']);
    }
}

