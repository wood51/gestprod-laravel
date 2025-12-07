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
            'lignes.typeSousEnsemble', // adapte le nom de la relation si différent
        ]);

        return view('commandes.show', compact('commande'));
    }
}

