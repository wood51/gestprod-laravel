<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'nom',
        'prenom',
        'username',
        'password',
        'role',
        'site',
    ];

    protected $hidden = [
        'password',
    ];

    public function defautProduits()
    {
        return $this->hasMany(DefautProduit::class);
    }
}
