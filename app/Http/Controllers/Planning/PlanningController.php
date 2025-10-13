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
    // /**
    //  * Display a listing of the resource.
    //  */
    // public function index(Request $request)
    // {
    //     $rows = $this->query($request)->orderByDesc('semaine')->get();
    //     $types = TypeSousEnsemble::all();
    //     $statuses = ['Fait', 'Reporté', 'En cours', 'Engagé'];
    //     return view('planning.index', compact('rows', 'statuses','types')); // TOUJOURS la vue complète
    // }

    // public function rows(Request $request)
    // {
    //     $rows = $this->query($request)->orderByDesc('semaine')->limit(50)->get();
    //     return response()->view('planning.partials.tbody', compact('rows'));   // UNIQUEMENT le tbody
    // }

    // private function query(Request $r)
    // {

    //     $q = VuePlanning::query();
    //     if ($r->filled('status')) $q->where('status', $r->string('status'));

    //     if ($r->filled('eng')) {
    //         $q->where('semaine_engagement', 'like', $r->string('eng') . '%');
    //     }

    //     if ($r->filled('type')) {
    //         $q->where('type', $r->string('type')); // ex: Alternateur, Compresseur
    //     }
    //     return $q;
    // }

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
