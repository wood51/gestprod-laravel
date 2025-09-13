<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeSousEnsemble extends Model
{
    use SoftDeletes;
    protected $fillable = ['designation'];

    public function typeEnsemble() {
        return $this->belongsTo(TypeEnsemble::class,'type_sous_ensemble_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function plannings()
    {
        return $this->hasMany(Planning::class);
    }
}