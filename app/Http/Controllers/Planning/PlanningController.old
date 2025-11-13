<?php

namespace App\Http\Controllers\Planning;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\TypeSousEnsemble;
use Illuminate\Http\Request;
use App\Models\VuePlanning;
use Illuminate\Support\Facades\DB;

class PlanningController extends Controller
{
    public function index(Request $request)
    {
        // On récupère les filtres proprement
        $reference = $request->string('refs')->trim()->toString();
        $status = $request->string('status')->trim()->toString();
        $eng    = $request->string('eng')->trim()->toString();
        $type   = $request->string('type')->trim()->toString();


        $rows = VuePlanning::query()
            ->when($reference !== '',fn($q)=> $q->where('refs',$reference))
            ->when($status !== '', fn($q) => $q->where('status', $status))
            ->when($eng    !== '', fn($q) => $q->where('semaine_engagement', 'like', $eng . '%'))
            ->when($type   !== '', fn($q) => $q->where('type', $type))
            ->orderByDesc('semaine_engagement')
            ->when($request->header('HX-Request'), fn($q) => $q->limit(50))
            ->get();

        // Appel HTMX (POST ou GET) → on renvoie juste le fragment <tr>…</tr>
        if ($request->header('HX-Request')) {
            return view('planning.partials.tbody', compact('rows'));
        }

        // Affichage complet (GET normal)
        $types    = TypeSousEnsemble::all();
        $refs = Article::all();
        $statuses = ['Fait', 'Reporté', 'En cours', 'Engagé'];

        return view('planning.index', compact('rows', 'statuses', 'types', 'refs'));
    }
}
