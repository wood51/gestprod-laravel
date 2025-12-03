<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Realisation extends Model
{
    use SoftDeletes;

    protected $fillable = ['article_id', 'type_sous_ensemble_id', 'numero', 'semaine', 'engagement', 'commentaire', 'prete'];
    // protected $casts = [ 'numero_meta' => 'array'];

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

    protected function numBl(): Attribute
{
    return Attribute::make(
        get: fn (): mixed => $this->bonLivraisons()->pluck('id')->all()
    );
}
}
