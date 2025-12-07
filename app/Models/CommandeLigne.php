<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Commande;
use App\Models\Article;
use App\Models\TypeSousEnsemble;

class CommandeLigne extends Model
{
    protected $fillable = [
        'commande_id',
        'article_id',
        'type_sous_ensemble_id',
        'poste_client',
        'qte_commandee',
        'qte_livree',
        'date_client',
        'date_ajustee',
        'status'
    ];

    protected $casts= [
        'date_client' => 'datetime',
        'date_ajustee' =>'datetime'
    ];

    public function commande() {
        return $this->belongsTo(Commande::class);
    }

    public function article() {
        return $this->belongsTo(Article::class);
    }

    public function typeSousEnsemble() {
        return $this->belongsTo(TypeSousEnsemble::class); // une commande peut référé a un rotor plutôt qu'un alternateur (sous ensemble <> sous ensemble de la ref)
    }
}
