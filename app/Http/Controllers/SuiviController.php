<?php

namespace App\Http\Controllers;

use App\Models\Suivi;
use App\Models\Article;
use Illuminate\Http\Request;

class SuiviController extends Controller
{
    public function index()
    {
        $articles = Article::with('typeSousEnsemble')->get();
        $suivis = Suivi::with(['article.typeSousEnsemble', 'operator'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('suivi.index', compact('suivis','articles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'article_id'     => 'required|exists:articles,id',
            'numero_produit' => 'required|string',
        ]);

        Suivi::create([
            'article_id'     => $request->article_id,
            'numero_produit' => $request->numero_produit,
            'operation'      => 'bobinage_stator', // hardcodé pour ton test
            'etat'           => 'attente',
        ]);

        return back()->with('info', 'Produit ajouté à la file d’attente !');
    }
}
