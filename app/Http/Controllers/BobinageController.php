<?php

namespace App\Http\Controllers;

use App\Models\Suivi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BobinageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Le suivi en cours pour l'opérateur
        $enCours = Suivi::operation('bobinage_stator')
            ->enCours()
            ->where('operator_id', $user->id)
            ->with('article.typeSousEnsemble')
            ->first();

        // Les produits en attente
        $enAttente = Suivi::operation('bobinage_stator')
            ->attente()
            ->whereHas('article.typeSousEnsemble', fn($q) =>
                $q->where('designation', 'Stator')
            )
            ->with('article.typeSousEnsemble')
            ->orderBy('created_at')
            ->get();

        return view('bobinage.index', compact('enCours', 'enAttente'));
    }

    public function start(Suivi $suivi)
    {
        $user = Auth::user();

        if ($suivi->etat !== 'attente') {
            return back()->with('error', 'Déjà pris...');
        }

        // Un seul suivi en cours par opérateur
        if (Suivi::operation('bobinage_stator')
            ->enCours()
            ->where('operator_id', $user->id)
            ->exists()
        ) {
            return back()->with('error', 'Tu as déjà un stator en cours.');
        }

        $suivi->update([
            'etat'        => 'en_cours',
            'operator_id' => $user->id,
            'started_at'  => now(),
        ]);

        return back();
    }

    public function stop(Suivi $suivi)
    {
        if ($suivi->etat !== 'en_cours') {
            return back()->with('error', 'Pas en cours.');
        }

        if ($suivi->operator_id !== $id   = Auth::id()) {
            return back()->with('error', 'Ce n’est pas ton suivi.');
        }

        $suivi->update([
            'etat'     => 'termine',
            'ended_at' => now(),
        ]);

        return back();
    }
}
