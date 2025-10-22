<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonLivraison extends Model
{
    protected $fillable = ['validated_at', 'canceled_at', 'created_by', 'validated_by', 'canceled_by'];

    public function lignes() {
        return $this->hasMany(BonLivraisonLigne::class);
    }
}
