<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = ['reference','designation', 'type_sous_ensemble_id', 'couleur', 'coefficient', 'commentaire'];

    public function typeSousEnsemble()
    {
        return $this->belongsTo(TypeSousEnsemble::class, 'type_sous_ensemble_id');
    }

    public function realisations()
    {
        return $this->hasMany(Realisation::class);
    }

    public function commande_lignes() {
        return $this->hasMany(CommandeLigne::class);
    }


}
