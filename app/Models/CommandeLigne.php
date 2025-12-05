<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
