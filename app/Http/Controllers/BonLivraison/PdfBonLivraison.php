<?php

namespace App\Http\Controllers\BonLivraison;

use App\Services\BonLivraison\BonLivraisonService;
use App\Models\BonLivraison;
use App\Models\User;
use TCPDF;

class PdfBonLivraison
{
    public function makePdf(int $no_bl, BonLivraisonService $service)
    {
        $bl = BonLivraison::findOrFail($no_bl);
        $date_bl = $bl->validated_at->format("d-m-Y");
        $lignes = $service->read($no_bl);
        $user = User::find($bl->validated_by);
        $username = ucfirst($user->prenom)." ".ucfirst($user->nom);

        $type=$bl->typeSousEnsemble->designation;

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->SetAuthor('GESTPROD DEE');              // optionnel
        $pdf->SetTitle("BL {$no_bl}");          // optionnel
        $pdf->SetAutoPageBreak(true, margin: 24);
        $pdf->SetMargins(10, 10, 10);           // optionnel

        $pdf->AddPage();                        // <— important
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setFooterFont(['times', '', 10]);

        $pdf->SetFont('times', '', 11);

        // Logo
        $pdf->Image(public_path('img/logo_DEE.png'), 10, 10, 45);
        $pdf->SetY(12);

        $title = view('bon_livraison.partials.pdfTitle', compact('bl'))->render();
        $pdf->writeHTML($title, true, false, true, false);
        $pdf->ln(13);

        $pdf->SetFont('times', '', 10);
        $adresse = view('bon_livraison.partials.pdfAdresseTable')->render();
        $pdf->writeHTML($adresse, true, false, true, false);
        $pdf->ln(7);

        $transport = view('bon_livraison.partials.pdfTransport')->render();
        $pdf->writeHTML($transport, true, false, true, false);
       

        $table = view('bon_livraison.partials.pdf'.$type.'Table', compact('lignes', 'bl'))->render();
        $pdf->writeHTML($table, true, false, true, false);
        $pdf->ln(1);

        $observation = view('bon_livraison.partials.pdf'.$type.'Observation', compact('lignes', 'bl'))->render();
        $pdf->writeHTML($observation, true, false, true, false);
        // $pdf->ln(2);

        $signature = view('bon_livraison.partials.pdfSignature', compact('lignes', 'bl','username'))->render();
        $pdf->writeHTML($signature, true, false, true, false);

        // Annulé
        // TODO image annulé insérer en conditionnel 
        // $pdf->StartTransform();
        // $pdf->Rotate(20, 50, 138);
        // $pdf->Image(public_path('img/annulé.png'), 0, 138.5, 175);
        // $pdf->StopTransform();

        $pdf->Output("BL_{$no_bl}.pdf", 'I');   // 'I' pour afficher, 'D' pour télécharger



    }
}
