<?php

namespace App\Http\Controllers\BonLivraison;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\BonLivraison;
use App\Models\BonLivraisonLigne;

class BonLivraisons extends Controller
{
    public function index() {
        $rows = BonLivraison::all();
        return view('bon_livraison.index',compact('rows'));
    }

    public function newBl() 
    {
        BonLivraison::create([
            'state' => 'draft',                  // valeur par défaut
            'created_by' => Auth::user()->id,     // si tu as la colonne
        ]);

        return back(); // simple: on revient sur la liste
    }

    public function showBlNumber(int $no_bl)
    {
        $bl = BonLivraison::find($no_bl);

        $lignes = BonLivraisonLigne::where('bon_livraison_id',  $no_bl)
            ->whereHas('planning.article')
            ->with([
                'planning:id,article_id,numero_meta,no_commande,no_poste',       // charger uniquement ce qu’il faut
                'planning.article:id,reference', // id requis pour la jointure + reference
            ])
            ->get() ?? [];

        return view('bon_livraison.bl', compact('lignes','bl'));
    }
}

