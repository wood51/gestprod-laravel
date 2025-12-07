<?php

namespace App\Http\Controllers;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

use App\Models\CommandeLigne;

class PdpController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $lignes = CommandeLigne::query()
            ->with(['commande', 'typeSousEnsemble'])
            ->whereIn('status', ['open', 'partial'])
            ->orderBy('date_ajustee')
            ->orderBy('date_client')
            ->orderBy('id')
            ->get()
            ->map(function ($ligne) use ($today) {
                $qCmd  = (int) $ligne->qte_commandee;
                $qLiv  = (int) $ligne->qte_livree;
                $reste = max($qCmd - $qLiv, 0);

                $retard = null;
                if ($ligne->date_ajustee && $ligne->date_ajustee->lt($today)) {
                    $retard = $ligne->date_ajustee->diffInDays($today);
                }

                $ligne->qte_reste = $reste;
                $ligne->retard_jours = $retard;

                return $ligne;
            });

        return view('pdp.index', compact('lignes', 'today'));
    }
}
