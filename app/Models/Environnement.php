<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Environnement extends Model
{
    protected $fillable = [
        'user_id',
        'operation_id',
        'description'
    ];


    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date'
    ];
}
