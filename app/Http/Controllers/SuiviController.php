<?php

namespace App\Http\Controllers;

use App\Models\Suivi;
use App\Models\Article;
use Illuminate\Http\Request;

class SuiviController extends Controller
{
    public function index()
    {
        $suivis = Suivi::with(['article.typeSousEnsemble', 'operator'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('suivi.index', compact('suivis'));
    }

    public function create()
    {
        // Tu peux filtrer les stators ici si tu veux
        $articles = Article::with('typeSousEnsemble')->get();

        return view('suivi.create', compact('articles'));
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

        return back()->with('success', 'Produit ajouté à la file d’attente !');
    }
}
