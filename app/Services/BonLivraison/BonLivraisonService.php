<?php

namespace App\Services\BonLivraison;

use App\Models\Realisation;

class BonLivraisonService
{

    // CRUD
    public function create($realisationIds) {
        // Récupérations des lignes slectionnés
        $realisations = Realisation::with('article')->whereIn('id',$realisationIds);
        // Gestion erreur
        
        // Vérification que les produit sont du m^me sous ensemble 
        $types = $realisations->pluck('type_sous_ensemble_id')->unique()->count();
        if ($types > 1 ) {
            throw new \ErrorException("Les produit doivent être du même type");
        }
        
        dd($types);
        return (object) ['bl'=>999];
    }

    public function read($no_bl) {}

    public function update($no_bl) {}

    public function delete($no_bl) {}

}
