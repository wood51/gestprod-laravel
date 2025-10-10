<?php

namespace App\Http\Controllers\Planning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VuePlanning;
use Illuminate\Support\Facades\DB;

class PlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rows = $this->query($request)->orderByDesc('semaine')->get();
        $statuses = ['Fait', 'Reporté', 'En cours', 'Engagé'];
        return view('planning.index', compact('rows', 'statuses')); // TOUJOURS la vue complète
    }

    public function rows(Request $request)
    {
        $rows = $this->query($request)->orderByDesc('semaine')->limit(50)->get();
        return view('planning.partials.tbody', compact('rows'));   // UNIQUEMENT le tbody
    }

    private function query(Request $r)
    {

        $q = VuePlanning::query();
        if ($r->filled('status')) $q->where('status', $r->string('status'));
        // (on ajoutera d'autres filtres ici plus tard)
        if ($r->filled('eng')) {
            // Normalise "2025-W41" -> "2025-41"
            $eng = preg_replace('/\b(\d{4})-W(\d{2})\b/i', '$1-$2', $r->string('eng'));
            // Préfixe pour taper "2025-4" et voir tout octobre par ex.
            $q->where('semaine_engagement', 'like', (string)$eng . '%');
        }

        if ($r->filled('type')) {
            $q->where('type', $r->string('type')); // ex: Alternateur, Compresseur
        }
        return $q;
    }
}
