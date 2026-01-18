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


    public static function splitPoste(string $poste): array
    {
        $poste = trim($poste);
        $parts = explode('.', $poste, 2);

        $main = (int) $parts[0];
        $sub  = isset($parts[1]) && $parts[1] !== '' ? (int) $parts[1] : 0;
        return [$main, $sub];
    }

    public function lignes() {
        return $this->hasMany(CommandeLigne::class);
    }
}
