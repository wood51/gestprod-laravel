<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [ 
        'client',
        'pa',
        'date_commande',
        'status',
    ];
}
