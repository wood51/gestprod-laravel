<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\CommandeLigne;
use App\Models\Commande;

class CommandeImportController extends Controller
{
    public function create()
    {
        return view('commandes.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        // 1) stocke le PDF
        $storedPdf = $request->file('pdf')->store('pa_pdfs');

        // 2) Paths
        $pdf = Storage::path($storedPdf);
        $python = base_path('scripts/pa_parser/.venv/bin/python');
        $script = base_path('scripts/pa_parser/parse_pa.py');
        $mapping = base_path('scripts/pa_parser/mapping.json');
        $codeMap = base_path('scripts/pa_parser/code_map.json');

        // 3) appel python
        $process = new Process([$python, $script, $pdf, '--mapping', $mapping, '--code-map', $codeMap, '--json-stdout',]);
        $process->setTimeout(30);
        $process->run();

        if (! $process->isSuccessful()) {
            // dd($process->getErrorOutput(), $process->getOutput());
            throw new ProcessFailedException($process);
        }

        $data = json_decode($process->getOutput(), true);

        // 4) Validation minimum
        if (!is_array($data) || empty($data['pa']) || !isset($data['lignes'])) {
            return back()->with("status", "JSON invalide.");
        }


        // 5) Créaton de la commande 
        $commande = Commande::create([
            'acheteur' => $data['acheteur'],
            'source_file' => $data['source_file'],
            'file_hash'=> md5_file($pdf),
            'date_commande' =>Carbon::createFromFormat('d/m/Y', $data['date_commande']),
            'pa' => $data['pa'],
            'is_avenant' => $data['is_avenant']
        ]);

        // 6) Création des lignes
        DB::transaction(function() use ($commande,$data) {
            if($commande->id) {
                foreach($data['lignes'] as $l) {
                    //dump($l);
                    CommandeLigne::create([
                        'commande_id'=> $commande->id,
                        'poste_client' => $l['poste'],
                        'article_id' => 1,
                        'code_article' => $l['code_article'],
                        'date_client' => Carbon::createFromFormat('d/m/Y',$l['date_livraison'] ),
                        'qte_commandee'=> $l['quantite'],
                        'type_sous_ensemble_id' => 1

                    ]);
                }
            }
        });

        return back()->with("status", "OK, fichier parser commande : $commande->id");
    }
}
