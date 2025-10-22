<?php

namespace App\Http\Controllers\BonLivraison;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BonLivraison;
use App\Models\BonLivraisonLigne;

class BonLivraisons extends Controller
{
    public function index(int $no_bl)
    {
        $lignes = BonLivraisonLigne::where('bon_livraison_id',  $no_bl)
            ->whereHas('planning.article')
            ->with([
                'planning:id,article_id,numero_meta,no_commande,no_poste',       // charger uniquement ce qu’il faut
                'planning.article:id,reference', // id requis pour la jointure + reference
            ])

            ->get();

    

        // echo "Ref | Qte | PA | Poste <br>";
        // foreach ($lignes as $key => $ligne) {
        //     echo $ligne->planning->article->reference." | ";
        //     echo "1 | ";
        //     echo $ligne->planning->no_commande." | ";
        //     echo $ligne->planning->no_poste."<br>";
        // }

        return view('bon_livraison.bl', compact('lignes'));
    }
}
