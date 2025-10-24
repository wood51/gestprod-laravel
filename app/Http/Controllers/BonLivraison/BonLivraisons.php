<?php

namespace App\Http\Controllers\BonLivraison;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\BonLivraison;
use App\Models\BonLivraisonLigne;

class BonLivraisons extends Controller
{
    public function index()
    {
        $rows = BonLivraison::all();
        return view('bon_livraison.index', compact('rows'));
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
            ->Has('planning.article')
            ->with([
                'planning:id,article_id,numero_meta,no_commande,no_poste',       // charger uniquement ce qu’il faut
                'planning.article:id,reference', // id requis pour la jointure + reference
            ])
            ->get()?? [];
        //  FIXME HERE pas ligne si valider .
       // dd($lignes);

        return view('bon_livraison.bl', compact('lignes', 'bl'));
    }

    public function deleteBl(int $no_bl)
    {
        $bl = BonLivraison::find($no_bl);

        if ($bl->state === 'draft') {
            $bl->delete();
        } else {
            $bl->state = 'canceled';
            $bl->update();
        }
        return back();
    }

    public function validateBl($no_bl)
    {

        $bl = BonLivraison::find($no_bl);


        $lignes = BonLivraisonLigne::where('bon_livraison_id',  $no_bl)
            ->whereHas('planning.article')
            ->with([
                'planning:id,article_id,numero_meta,no_commande,no_poste',       // charger uniquement ce qu’il faut
                'planning.article:id,reference', // id requis pour la jointure + reference
            ])
            ->get() ?? [];

        DB::transaction(function () use ($bl, $lignes) {
            // Maj etat Bl
            $bl->state = 'validated';
            $bl->update();

            // on fige les lignes
            foreach ($lignes as $l) {
                $l->numero_meta = $l->planning->numero_meta;
                $l->article_ref = $l->planning->article->reference;
                // $l->article_designation=$l->planning->article->designation; // FIXME Oublier la colonne designation dans articles
                $l->quantite = 1;
                $l->no_commande = $l->planning->no_commande;
                $l->poste = $l->planning->no_poste; //FIXME modofier colonnes bl lignes poste-> no_poste

                // on supprimme le liens du planning 
                //$l->planning_id=null; // FIXME commenter pour debug
                $l->update();
            }
        });



        return redirect()->route('bl.index');
    }
}
