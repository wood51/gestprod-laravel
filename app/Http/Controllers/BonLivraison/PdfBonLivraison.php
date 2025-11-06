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
        $date_bl = $bl->validated_at->format("d-m-Y");
        $lignes = $service->read($no_bl);
        $html = view('bon_livraison.pdf_bl', compact('lignes', 'bl'))->render();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->SetAuthor('GESTPROD DEE');              // optionnel
        $pdf->SetTitle("BL {$no_bl}");          // optionnel
        $pdf->SetMargins(10, 10, 10);           // optionnel

        $pdf->AddPage();                        // <— important
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setFooterFont(['times', '', 10]);

         $pdf->SetFont('times', '', 10);
        // $pdf->MultiCell(0, 0, "BON DE LIVRAISON N°$no_bl \ndu $date_bl\n", 0, 'C');
        $pdf->writeHTML($html,false,true,false,false,'C');
        
        $pdf->Output("BL_{$no_bl}.pdf", 'I');   // 'I' pour afficher, 'D' pour télécharger


    }
}

