<?php

namespace App\Http\Controllers\BonLivraison;

use App\Http\Controllers\Controller;
use App\Services\BonLivraison\BonLivraisonService;
use Illuminate\Http\Request;

use App\Models\BonLivraison;


class BonLivraisons extends Controller
{
    public function index()
    {
        $rows = BonLivraison::all();
        return view('bon_livraison.index', compact('rows'));
    }

   

    public function addRealisationsToBl(Request $request, BonLivraisonService $service)
    {
        
    }


    public function showBlNumber(int $no_bl, BonLivraisonService $service)
    {

    }

    public function deleteBl(int $no_bl, BonLivraisonService $service)
    {

    }

    public function validateBl($no_bl, BonLivraisonService $service)
    {

    }
}
