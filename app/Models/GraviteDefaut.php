<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraviteDefaut extends Model
{
    protected $fillable = [
        'libelle',
        'poids',
        'couleur',
        'commentaire'
    ];

    public function CatalogueDefauts()
    {
        return $this->hasMany(CatalogueDefaut::class);
    }
}
