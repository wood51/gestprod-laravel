<?php

namespace App\Services\BonLivraison;

use \Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\DB;

use App\Models\BonLivraison;
use App\Models\BonLivraisonLigne;
use App\Models\Realisation;

class BonLivraisonService
{

    public function create($realisationIds)
    {
        // Récupérations des lignes slectionnés
        $realisations = Realisation::whereIn('id', $realisationIds)->get(); // FIXME Pourquoi les article s?
        // $realisations = Realisation::with('article')->whereIn('id',$realisationIds)->get(); // FIXME Pourquoi les article s?

        // Gestion erreur
        if ($realisations->count() < 1) throw new \ErrorException("Aucune réalisations trouvé");

        // Vérification que les produit sont du même sous ensemble 
        $type = $realisations->pluck('type_sous_ensemble_id')->unique();
        if ($type->count() > 1) throw new \ErrorException("Les produit doivent être du même type");

        // Rechercher si un bl de ce type_sous_ensemble existe en brouillon 
        $bl = BonLivraison::where('type_sous_ensemble_id', "=", $type, 'and')
            ->where('state', '=', 'draft')
            ->get();

        $bl_id = $bl->isEmpty()
            ? $this->createBl($type->first(), $realisations)
            : $this->appendToBl($bl->first(), $realisations);



        return $bl_id;
    }

    public function read($no_bl)
    {

        $bl_id = $this->getBlId($no_bl);
        $lines = BonLivraisonLigne::where('bon_livraison_id', '=', $bl_id)
            ->with([
                'realisation:id,article_id,numero_meta,no_commande,no_poste',
                'realisation.article:id,reference,ref_client,designation'
            ])->get();

        return $lines;
    }

    public function update($no_bl)
    {
        $bl_id = $this->getBlId($no_bl);
        dd("update");
    }

    public function delete($no_bl)
    {
        $bl_id = $this->getBlId($no_bl);
        dd("delete bl n° $no_bl");
        return;
    }

    private function createBl($type, $realisations)
    {
        $bl = DB::transaction(function () use ($type, $realisations) {
            $bl = BonLivraison::create([
                'type_sous_ensemble_id' => $type,
                'state' => 'draft',
                'created_by' => Auth::user()->id,
                'no_bl' => BonLivraison::whereNotNull('no_bl')->max('no_bl') + 1
            ]);

            foreach ($realisations as $realisation) {
                $this->appendLine($bl->id, $realisation);
            }

            return $bl;
        });
        return $bl;
    }

    private function appendToBl($bl, $realisations)
    {
        DB::transaction(function () use ($bl, $realisations) {

            foreach ($realisations as $realisation) {
                $this->appendLine($bl->id, $realisation);
            }
        });
        return $bl->id;
    }

    private function appendLine($bl_id, $realisation)
    {

        BonLivraisonLigne::create([
            'bon_livraison_id' => $bl_id,
            'realisation_id' => $realisation->id
        ]);
    }


    private function getBlId(string|int $no_bl): int
    {
        $id = BonLivraison::where('no_bl', $no_bl)->value('id');

        if (!$id) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException("BL {$no_bl} introuvable");
        }

        return (int) $id;
    }
}
