<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeEnsemble extends Model
{
    protected $fillable = ['type_sous_ensemble_id','libelle','ordre_affichage'];

    public function typeSousEnsembles() {
        return $this->hasMany(TypeSousEnsemble::class);
    }
}
