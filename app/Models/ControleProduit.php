<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ControleProduit extends Model
{
    protected $fillable = ['planning_id', 'etat_id', 'hasDefault', 'commentaire'];
    protected $casts = ['hasDefault' => 'boolean'];
    public function realisation()
    {
        return $this->belongsTo(Realisation::class);
    }

    public function etat()
    {
        return $this->belongsTo(Etat::class);
    }

    public function defautProduits()
    {
        return $this->hasMany(DefautProduit::class);
    }
}
