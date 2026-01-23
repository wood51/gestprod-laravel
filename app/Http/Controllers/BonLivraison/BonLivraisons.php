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

    public function createBl(Request $request, BonLivraisonService $blSvc)
    {
        $data = $request->validate([
            'realisationIds'   => ['required', 'array', 'min:1'],
            'realisationIds.*' => ['integer', 'exists:realisations,id'],
        ]);

        $bl = $blSvc->create($data['realisationIds']);
        
        return redirect()
           ->route('bl.show', $bl->id)
           ->with('success', 'Bon de livraison créé.');
    }


    public function showBl(int $no_bl, BonLivraisonService $blSvc)
    {
        dd("show bl no");
    }

    public function deleteBl(int $no_bl, BonLivraisonService $blSvc)
    {
        dd("delete bl no ");
    }

    public function validateBl($no_bl, BonLivraisonService $blSvc)
    {
        dd("validate bl no ");
    }
}
