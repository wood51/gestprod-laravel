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
use App\Models\Article;

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
            if ($process->getExitCode() == 2) {
                dd($process->getErrorOutput(), $process->getOutput());
                throw new ProcessFailedException($process);
            }
        }

        $data = json_decode($process->getOutput(), true);

        // dd($data);

        // 4) Validation minimum
        if (!is_array($data) || empty($data['pa']) || !isset($data['lignes'])) {
            return back()->with("status", "JSON invalide.");
        }


        // 6) Création des lignes
        $commandeId = DB::transaction(function () use ($data, $pdf) {
            $commande = Commande::create([
                'acheteur' => $data['acheteur'],
                'source_file' => $data['source_file'],
                'file_hash' => md5_file($pdf),
                'date_commande' => Carbon::createFromFormat('d/m/Y', $data['date_commande']),
                'pa' => $data['pa'],
                'is_avenant' => $data['is_avenant']
            ]);


            foreach ($data['lignes'] as $l) {
                $article = Article::where('ref_client', '=', $l['code_article'])->first();

                if (!$article) {
                    // logger()->warning("Article manquant", ['code_article' => $l['code_article'], 'poste' => $l['poste']]);
                    if (!$article) {
                        dd([
                            'code_article' => $l['code_article'],
                            'poste' => $l['poste'],
                            'ligne_json' => $l,
                            'articles_count_same_ref_client' => Article::where('ref_client', $l['code_article'])->count(),
                        ]);
                    }
                }


                CommandeLigne::create([
                    'commande_id' => $commande->id,
                    'poste_client' => $l['poste'],
                    'article_id' => $article?->id,
                    'code_article' => $l['code_article'],
                    'date_client' => Carbon::createFromFormat('d/m/Y', $l['date_livraison']),
                    'qte_commandee' => $l['quantite'],
                    'type_sous_ensemble_id' => $article?->type_sous_ensemble_id

                ]);
            }

            return $commande->id;
        });

        return redirect()
            ->route('commandes.show', $commandeId)
            ->with('status', "Import OK : commande #$commandeId");
    }
}
