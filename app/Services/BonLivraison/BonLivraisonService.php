<?php

namespace App\Services\Bonlivraison;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\BonLivraison;
use App\Models\BonLivraisonLigne;
use App\Models\Realisation;
use App\Models\v10_pa_map;

use function PHPUnit\Framework\isNull;

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
                if (! $l->numero_meta)   $l->numero_meta = $l->realisation->numero_meta;
                if (!$l->article_ref)   $l->article_ref = $l->realisation->article->reference;
                // FIXME remplir les désignation 
                if (!$l->article_designation)   $l->article_designation = $l->realisation->article->designation;
                $l->quantite = 1;

                if (!$l->no_commande) {
                    // $l->no_commande =$l->realisation?->no_commande;
                    switch ($l->code_prefix) {
                        case '4501':
                            $l->no_commande = $l->realisation?->no_commande;
                            break;
                        case '4031':
                            $map = v10_pa_map::where('realisation_id', $l->realisation_id)->first();
                            $l->no_commande = $map->pa_4031;
                            break;
                        case '403':
                            $map = v10_pa_map::where('realisation_id', $l->realisation_id)->first();
                            $l->no_commande = $map->pa_403;
                            break;
                    }
                }


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

                if ($real->is_st) {
                    BonLivraisonLigne::create([
                        'bon_livraison_id'      => $bl->id,
                        'realisation_id'        => $real->id,
                        'code_prefix' => '4501'
                    ]);
                } else {
                    $id = BonLivraisonLigne::create([
                        'bon_livraison_id'      => $bl->id,
                        'realisation_id'        => $real->id,
                        'code_prefix' => '4501'
                    ]);
                    dd($id);
                    $this->createV10Pack($bl, $real);
                }
            }

            $bl->update(['nb_lines' => $bl->lignes()->count()]);

            return $bl;
        });
    }

    public function createV10Pack($bl, $real)
    {
        $numero_meta = json_encode([
            'Alternateur n°' => '',
            'Rotor n°' => '',
            'Stator n°' => json_decode($real->numero_meta, true)['Stator n°'],
        ],  true);


        $pas = v10_pa_map::create([
            'realisation_id' => $real->id
        ]);


        BonLivraisonLigne::create([
            'bon_livraison_id'      => $bl->id,
            'realisation_id'        => $real->id,
            'article_ref'        => '4031AS280L240V10-T',
            'article_designation' => 'EMPILAGE STATOR AS280L240-28V10 SOUS TRAITE',
            'code_prefix' => '4031',
            'numero_meta' => $numero_meta
        ]);

        BonLivraisonLigne::create([
            'bon_livraison_id'      => $bl->id,
            'realisation_id'        => $real->id,
            'article_ref'        => '403AS280L240V10',
            'article_designation' => 'BOBINAGE STATOR AS280L240V10 SOUS TRAITE',
            'code_prefix' => '403',
            'numero_meta' => $numero_meta
        ]);
    }
}
