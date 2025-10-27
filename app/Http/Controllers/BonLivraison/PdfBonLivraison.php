<?php

namespace App\Http\Controllers\BonLivraison;

use App\Services\BonLivraison\BonLivraisonService;
use App\Models\BonLivraison;
use TCPDF;

class PdfBonLivraison
{
    public function makePdf(int $no_bl, BonLivraisonService $service)
    {
        $bl = BonLivraison::findOrFail($no_bl);
        $lignes = $service->read($no_bl);

        $html = view('bon_livraison.pdf_bl', compact('lignes', 'bl'))->render();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetAuthor('TonApp');              // optionnel
        $pdf->SetTitle("BL {$no_bl}");          // optionnel
        $pdf->SetMargins(10, 10, 10);           // optionnel
        $pdf->AddPage();                        // <— important
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output("BL_{$no_bl}.pdf", 'I');   // 'I' pour afficher, 'D' pour télécharger
    }
}