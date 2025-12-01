<?php

namespace App\Http\Controllers\Realisation;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\TypeSousEnsemble;
use Illuminate\Http\Request;
use App\Models\VueRealisation;
use Illuminate\Support\Facades\DB;

class RealisationController extends Controller
{
    public function index(Request $request)
{
    $reference = $request->string('refs')->trim()->toString();
    $status    = $request->string('status')->trim()->toString();
    $eng       = $request->string('eng')->trim()->toString();
    $type      = $request->string('type')->trim()->toString();

    $query = VueRealisation::query()
        ->when($reference !== '', fn($q) => $q->where('reference', $reference))
        ->when($status    !== '', fn($q) => $q->where('status', $status))
        ->when($eng       !== '', fn($q) => $q->where('semaine_engagement', 'like', $eng.'%'))
        ->when($type      !== '', fn($q) => $q->where('type', $type))
        ->orderByDesc('semaine_engagement')
        ->orderBy('reference');

    $rows = $query->paginate(14)->withQueryString();

    $types    = TypeSousEnsemble::all();
    $refs     = Article::all();
    $statuses = ['Fait', 'Reporté', 'En cours', 'Engagé'];

    // Si HTMX → on renvoie juste la zone table + pagination
    if ($request->header('HX-Request')) {
        return view('realisation.partials.table', compact('rows', 'statuses', 'types', 'refs'));
    }

    // Sinon, la page complète
    return view('realisation.index', compact('rows', 'statuses', 'types', 'refs'));
}

}
