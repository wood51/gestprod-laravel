<?php

namespace App\Http\Controllers;

use App\Models\BonLivraisonLigne;
use setasign\Fpdi\Tcpdf\Fpdi;
use Illuminate\Http\Request;

class PageGarde extends Controller
{
    public function generatePageGarde($no_bl)
    {
        $numeroMachine = '1234';
        $numeroPa = 'PA-XXXXXXX';
        $numeroRotor = '1234';
        $numeroStator = '1234';

        
        
        $modeles=BonLivraisonLigne::where('bon_livraison_id','=',$no_bl)->get();
        

        $pdf = new Fpdi();

        $pdf->SetMargins(0, 0, 0);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetAutoPageBreak(false, 0);

        foreach ($modeles as $modele) {

            $template = "PG_$modele->article_ref";
            $basePath = "pdf_templates/page_garde";

            $jsonPath = resource_path("$basePath/$template.json");
            $pdfPath = resource_path("$basePath/$template.pdf");



            if (! file_exists($pdfPath)) {
                abort(400, "Template PDF introuvable : {$pdfPath}");
            }

            if (! file_exists($jsonPath)) {
                abort(400, "Template JSON introuvable : {$jsonPath}");
            }

            $config = json_decode(file_get_contents($jsonPath), true);
            $num =$modele->numero_meta;
            // 2) Création du PDF FPDI
            
            // 3) On charge le template
            $pdf->setSourceFile($pdfPath);
            $pdf->AddPage('P', 'A4');
            $tplId = $pdf->importPage(1);
            $pdf->useTemplate($tplId, 0, 0, 210, 297);
            
            // 4) On écrit par-dessus
            $pdf->SetFont('helvetica', '', 10);
            $pdf->SetTextColor(0, 0, 0);
            
            $this->renderField($pdf, $config['fields']['numero_machine'], $num['Alternateur n°']);
            $this->renderField($pdf, $config['fields']['numero_pa'], $modele->no_commande);
            $this->renderField($pdf, $config['fields']['numero_rotor'], $num['Rotor n°']);
            $this->renderField($pdf, $config['fields']['numero_stator'], $num['Stator n°']);
            if (isset($config['fields']['footer_bl'])) {
                $this->renderField($pdf, $config['fields']['footer_bl'], $num['Stator n°']);
            };
        }


        // 5) Retour au navigateur
        return response($pdf->Output('page_garde.pdf', 'S'), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="page_garde.pdf"',
        ]);
    }

    public function renderField(Fpdi $pdf, array $field, string $text)
    {
        $pdf->SetXY($field['x'], $field['y']);
        $pdf->Write(0, $text);
    }
}
