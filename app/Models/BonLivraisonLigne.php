<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BonLivraisonLigne extends Model
{
    public function planning()
    {
        return $this->belongsTo(Planning::class);
    }
}
