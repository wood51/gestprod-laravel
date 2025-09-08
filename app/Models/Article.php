<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable = ['reference', 'type_sous_ensemble_id', 'couleur', 'coefficient', 'commentaire'];

    public function typeSousEnsemble()
    {
        return $this->belongsTo(TypeSousEnsemble::class, 'type_sous_ensemble_id');
    }

    public function plannings()
    {
        return $this->hasMany(Planning::class);
    }


}
