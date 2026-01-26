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
        try {
            $data = $request->validate([
                'realisationIds'   => ['requiresd', 'array', 'min:1'],
                'realisationIds.*' => ['integer', 'exists:realisations,id'],
            ]);

            $bl = $blSvc->create($data['realisationIds']);
            return redirect()
                ->route('bl.show', $bl)
                ->with('success', 'Bon de livraison créé.');
        } catch (\Throwable $ex) {
            throw new \ErrorException($ex->getMessage());
        }
    }


    public function showBl(int $no_bl, BonLivraisonService $blSvc)
    {
        $bl = BonLivraison::where('no_bl','=',$no_bl)->first();
        $lignes = $blSvc->read($no_bl);
        return view('bon_livraison.bl', compact('lignes', 'bl'));
    }

    public function deleteBl(int $no_bl, BonLivraisonService $blSvc)
    {
        $bl = BonLivraison::find($no_bl);
        $blSvc->delete($no_bl);
        return back();
    }

    public function validateBl($no_bl, BonLivraisonService $blSvc)
    {
        dd("validate bl no ");
    }
}
