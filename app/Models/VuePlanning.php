<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VuePlanning extends Model
{
    protected $table = 'vue_plannings';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
}
