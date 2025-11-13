<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VueRealisation extends Model
{
    protected $table = 'vue_realisations';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
}

