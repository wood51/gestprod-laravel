<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControleProduit extends Model
{
    protected $fillable=['hasDefault','commentaire'];

    public function planning() {
        return $this->belongsTo(Planning::class,'planning_id');
    }

    public function etat() {
        return $this->belongsTo(Etat::class,'etat_id');
    }
}
