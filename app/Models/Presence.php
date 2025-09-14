<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $fillable = ['nb_operateurs', 'nb_heures_normales', 'nb_heures_supp', 'date_jour', 'heures_supp', 'commentaire'];
}
