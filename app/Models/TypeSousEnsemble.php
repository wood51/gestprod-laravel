<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeSousEnsemble extends Model
{
    use SoftDeletes;
    protected $fillable = ['designation'];

    protected $casts = ['modele_numero' => 'array'];

    public function typeEnsemble()
    {
        return $this->belongsTo(TypeEnsemble::class, 'typee_ensemble_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function realisations()
    {
        return $this->hasMany(Realisation::class);
    }

    public function catalogueDefauts()
    {
        return $this->hasMany(CatalogueDefaut::class);
    }
}
