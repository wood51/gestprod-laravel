<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Planning extends Model
{
    use SoftDeletes;

    protected $fillable = ['article_id', 'type_sous_ensemble_id', 'numero', 'semaine', 'engagement', 'commentaire', 'prete'];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function typeSousEnsemble()
    {
        return $this->belongsTo(TypeSousEnsemble::class, 'type_sous_ensemble_id');
    }

    public function controleProduits()
    {
        return $this->hasMany(ControleProduit::class, 'planning_id');
    }
}
