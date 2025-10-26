<?php

namespace App\Services\Bonlivraison;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BonLivraison;
use App\Models\BonLivraisonLigne;

class BonLivraisonService
{
    public function create()
    {
        BonLivraison::create([
            'state' => 'draft',                  // valeur par défaut
            'created_by' => Auth::id(),     // si tu as la colonne
        ]);
    }

    public function read($no_bl)
    {
        $lines = BonLivraisonLigne::where('bon_livraison_id',  $no_bl)
            ->with([
                'planning:id,article_id,numero_meta,no_commande,no_poste',
                'planning.article:id,reference,designation',
            ])
            ->get();

        return $lines;
    }

    public function update($no_bl)
    {
        $bl = BonLivraison::findOrFail($no_bl);
        $lignes = $this->read($no_bl);
        DB::transaction(function () use ($bl, $lignes) {
            // Maj etat Bl
            $bl->state = 'validated';
            $bl->save();
            foreach ($lignes as $l) {
                $l->numero_meta = $l->planning->numero_meta;
                $l->article_ref = $l->planning->article->reference;
                $l->article_designation = $l->planning->article->designation;
                $l->quantite = 1;
                $l->no_commande = $l->planning->no_commande;
                $l->no_poste = $l->planning->no_poste; 

                // on supprimme le liens du planning 
                $l->planning_id = null;
                $l->save();
            }
        });

        return;
    }

    public function delete($no_bl)
    {
        $bl = BonLivraison::findOrFail($no_bl);

        if ($bl->state === 'draft') {
            $bl->delete();
        } else {
            $bl->state = 'canceled';
            $bl->update();
        }

        return;
    }
}
