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

    public function newBl(BonLivraisonService $service)
    {
        $service->create();
        return back();
    }

    public function addRealisationsToBl(Request $request, BonLivraisonService $service)
    {
        $ids = $request->input('realisationIds', []);

        if (empty($ids)) {
            return back()->with('error', 'Aucune réalisation sélectionnée.');
        }

        $bl = $service->addRealisationsToBlForType($ids);

        return redirect()
            ->route('bl.show', $bl->id)
            ->with('success', "Ajouté au BL n°{$bl->id}");
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
