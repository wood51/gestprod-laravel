<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeSousEnsemble extends Model
{
    use SoftDeletes;
    protected $fillable = ['designation'];

    public function typeEnsemble()
    {
        return $this->belongsTo(TypeEnsemble::class, 'typee_ensemble_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function plannings()
    {
        return $this->hasMany(Planning::class);
    }

    public function catalogueDefauts()
    {
        return $this->hasMany(CatalogueDefaut::class);
    }
}
