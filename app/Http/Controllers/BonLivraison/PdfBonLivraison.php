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
        $date_bl = $bl->validated_at->format("j-m-Y");
        $lignes = $service->read($no_bl);
        $html = view('bon_livraison.pdf_bl', compact('lignes', 'bl'))->render();

        $pdf = new TcPdfExtend(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(true);
        $pdf->SetAuthor('GESTPROD DEE');              // optionnel
        $pdf->SetTitle("BL {$no_bl}");          // optionnel
        $pdf->SetMargins(10, 10, 10);           // optionnel

        $pdf->AddPage();                        // <— important
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setFooterFont(['times', '', 10]);

        $pdf->SetFont('times', 'B', 14);
        $pdf->MultiCell(0, 0, "BON DE LIVRAISON N°$no_bl \ndu $date_bl", 0, 'C');
        $pdf->loadData();
        $pdf->Output("BL_{$no_bl}.pdf", 'I');   // 'I' pour afficher, 'D' pour télécharger
    }
}

class TcPdfExtend extends TCPDF
{
    public function Footer()
    {
        $this->setY(-15);
        $this->SetFont('times', '', 10);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public function LoadData() // FIXME Test pour debug
    {
        $service = new BonLivraisonService();
        $no_bl = 1;
        $bl = BonLivraison::findOrFail($no_bl);
        $date_bl = $bl->validated_at->format("j-m-Y");
        $lignes = $service->read($no_bl);

        // Titre
        echo nl2br("BON DE LIVRAISON N°$no_bl\ndu $date_bl\n\n");

        // Headers
        echo "Reference\t";
        echo "Designation\t";
        echo "N° Cmde\t";
        echo "Poste\t";
        foreach ($lignes->first()->numero_meta as $key => $value) {
            echo $key . "\t";
        }
        
        // Lignes
        echo nl2br("\n");
        foreach ($lignes as $ligne) {
            echo nl2br("$ligne->article_ref\t$ligne->article_designation\t$ligne->no_commande\t$ligne->no_poste\t");
            foreach($ligne->numero_meta as $num) {
                echo nl2br("$num\t");
            }
            echo nl2br("\n");
        }


        die();
    }
}
