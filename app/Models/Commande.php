<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [ 
        'acheteur',
        'client',
        'source_file',
        'file_hash',
        'is_avenant',
        'pa',
        'date_commande',
        'status',
    ];

    protected $casts = [
        'date_commande' => 'datetime',
    ];

    public function lignes() {
        return $this->hasMany(CommandeLigne::class);
    }
}
