<?php

namespace App\Http\Controllers\BonLivraison;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\BonLivraison\BonLivraisonService;

use App\Models\BonLivraison;
use App\Models\BonLivraisonLigne;


class BonLivraisons extends Controller
{
    public function index()
    {
        $rows = BonLivraison::all();
        return view('bon_livraison.index', compact('rows'));
    }

    public function newBl(BonLivraisonService $service)
    {
        $service->create();
        return back();
    }

    public function showBlNumber(int $no_bl, BonLivraisonService $service)
    {
        $bl = BonLivraison::findOrFail($no_bl);

        $lignes = $service->read($no_bl);
        return view('bon_livraison.bl', compact('lignes', 'bl'));
    }

    public function deleteBl(int $no_bl, BonLivraisonService $service)
    {
        $service->delete($no_bl);
        return back();
    }

    public function validateBl($no_bl, BonLivraisonService $service)
    {
        $service->update($no_bl);
        return redirect()->route('bl.index');
    }
}
