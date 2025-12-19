<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    // public function showDashboard()
    // {
    //     $week = session('week', now()->format('o-W'));
    //     $weekISO = session('weekISO', now()->format('o-\WW'));
    //     $nb_week = session('nb_week', 4);

    //     return view('kpi.dashboard', ['week' => $week, 'weekISO' => $weekISO, 'nb_week' => $nb_week]);
    // }
    public function showDashboard()
{
    // Si tu as déjà une week en session, on la respecte (si tu veux garder le switch manuel)
    // sinon on applique ton fallback.
    $week = session('week');

    if (!$week) {
        $today = now(); // timezone app (Europe/Paris chez toi)
        $isoDay = $today->isoWeekday(); // 1=lundi ... 7=dimanche

        $week = ($isoDay <= 2) // Lundi(1) ou Mardi(2)
            ? $today->copy()->subWeek()->format('o-W')
            : $today->format('o-W'); // Mercredi->Dimanche
    }

    // format pour input type="week" : YYYY-Www
    [$year, $w] = explode('-', $week);
    $weekISO = sprintf('%s-W%02d', $year, (int)$w);

    $nb_week = session('nb_week', 4);

    return view('kpi.dashboard', compact('week', 'weekISO', 'nb_week'));
}


    // public function setDashboardWeek(string $week)
    // {
    //     [$annee, $semaine] = explode('-', $week);
    //     $weekISO = sprintf('%s-W%02d', $annee, $semaine);

    //     session(['week' => $week]);
    //     session(['weekISO' => $weekISO]);
    //     return response()->noContent();
    // }

    public function setDashboardWeek(Request $request)
    {
        $validated = $request->validate([
            'week' => ['required', 'regex:/^\d{4}-(W?\d{1,2})$/'], // "2025-W35"
        ]);

        // normalise en YYYY-Www
        echo "here";
        [$annee, $semaineRaw] = explode('-', $validated['week']);
        $semaine = ltrim($semaineRaw, 'Ww'); // vire le W si présent
        $weekISO = sprintf('%s-W%02d', $annee, $semaine);

        $request->session()->put('week', "{$annee}-{$semaine}");
        $request->session()->put('weekISO' , $weekISO);


        return to_route('dashboard');
    }
}
