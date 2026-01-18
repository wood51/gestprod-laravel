<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::query()
            ->withCount('lignes') // ->lignes_count
            ->withSum('lignes as qte_commandee_sum', 'qte_commandee')
            ->withSum('lignes as qte_livree_sum', 'qte_livree')
            ->orderByDesc('date_commande')
            ->orderBy('pa')
            ->get();


        return view('commandes.index', compact('commandes'));
    }

    public function show(Commande $commande)
    {
        $commande->load([
            'lignes' => function ($q) {
                $q->orderByRaw("
                CAST(SUBSTRING_INDEX(poste_client, '.', 1) AS UNSIGNED) ASC,
                COALESCE(
                    CAST(NULLIF(SUBSTRING_INDEX(poste_client, '.', -1), poste_client) AS UNSIGNED),
                    0
                ) ASC
            ");
            },
            'lignes.typeSousEnsemble',
        ]);

        return view('commandes.show', compact('commande'));
    }
}
