<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogueDefaut extends Model
{
    protected $fillable = [
        'mot_cle',
        'type_sous_ensemble_id',
        'categorie_defaut',
        'gravite_id',
        'description'
    ];

    public function TypeSousEnsemble()
    {
        return $this->belongsTo(TypeSousEnsemble::class, 'type_sous_ensemble_id');
    }

    public function Gravite()
    {
        return $this->belongsTo(GraviteDefaut::class, 'gravite_id');
    }

    public function defautProduits()
    {
        return $this->hasMany(DefautProduit::class, 'catalogue_defaut_id');
    }
}
