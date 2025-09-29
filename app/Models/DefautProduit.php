<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefautProduit extends Model
{
    protected  $fillable = [
        'controle_produit_id',
        'type_sous_ensemble_id',
        'catalogue_defaut_id',
        'user_id',
        'commentaire',
        'date'
    ];

    protected $casts = ['date' => 'datetime'];

    public function controleProduit()
    {
        return $this->belongsTo(ControleProduit::class);
    }

    public function typeSousEnsemble()
    {
        return $this->belongsTo(TypeSousEnsemble::class);
    }

    public function catalogueDefaut()
    {
        return $this->belongsTo(CatalogueDefaut::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
