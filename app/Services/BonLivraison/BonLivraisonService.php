<?php

namespace App\Services\BonLivraison;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BonLivraison;
use App\Models\BonLivraisonLigne;
use App\Models\Realisation;


class BonLivraisonService
{

    // CRUD
    public function create()
    {
        BonLivraison::create([
            'state' => 'draft',
            'created_by' => Auth::id(),
        ]);
    }

    public function read($no_bl)
    {
        $lines = BonLivraisonLigne::where('bon_livraison_id',  $no_bl)
            ->with([
                'realisation:id,article_id,numero_meta,no_commande,no_poste',
                'realisation.article:id,reference,designation',
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
            $bl->validated_by = Auth::id();
            $bl->validated_at = now();
            $bl->save();

            foreach ($lignes as $l) {
                $l->numero_meta = $l->realisation->numero_meta;
                $l->article_ref = $l->realisation->article->reference;
                $l->article_designation = $l->realisation->article->designation;
                $l->quantite = 1;
                $l->no_commande = $l->realisation?->no_commande;
                $l->no_poste = $l->realisation?->no_poste;
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
            $bl->canceled_by = Auth::id();
            $bl->canceled_at = now();
            $bl->update();
        }

        return;
    }

    public function addRealisationsToBlForType(array $realisationIds): BonLivraison
    {
        return DB::transaction(function () use ($realisationIds) {

            $reals = Realisation::with('article')
                ->whereIn('id', $realisationIds)
                ->get();

            if ($reals->isEmpty()) {
                abort(400, 'Aucune réalisation trouvée.');
            }

            // on vérifie qu’il n’y a qu’un seul type_sous_ensemble
            $types = $reals->pluck('type_sous_ensemble_id')->unique();
            if ($types->count() > 1) {
                abort(400, 'Les réalisations sélectionnées doivent être du même type.');
            }
            $typeId = $types->first();

            // 1 seul BL draft par type_sous_ensemble
            $bl = BonLivraison::where('state', 'draft')
                ->where('type_sous_ensemble_id', $typeId)
                ->first();

            if (! $bl) {
                $bl = BonLivraison::create([
                    'type_sous_ensemble_id' => $typeId,
                    'state'                 => 'draft',
                    'created_by'            => Auth::id(),
                ]);
            }

            foreach ($reals as $real) {

                // éviter les doublons
                $exists = $bl->lignes()
                    ->where('realisation_id', $real->id)
                    ->exists();

                if ($exists) {
                    continue;
                }

                BonLivraisonLigne::create([
                    'bon_livraison_id'      => $bl->id,
                    'realisation_id'        => $real->id,
                ]);
            }

            $bl->update(['nb_lines' => $bl->lignes()->count()]);

            return $bl;
        });
    }
}
