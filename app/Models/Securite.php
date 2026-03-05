<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Securite extends Model
{
    protected $fillable = [
        'user_id',
        'sst_id',
        'operation_id'
    ];


    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date'
    ];
}
