<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suivi extends Model
{

    protected $table = 'suivis';

    protected $fillable = [
        'article_id',
        'numero_produit',
        'operation',
        'etat',
        'operator_id',
        'started_at',
        'ended_at',
    ];

    protected $dates = ['started_at', 'ended_at'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // Le modèle (AS250M150V3)
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    // L’opérateur
    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    // Exemple : "AS250M150V3 Stator N°6589"
    public function getLibelleAttribute()
    {
        $type = $this->article->typeSousEnsemble->designation ?? '';

        return "{$this->article->reference} {$type} N°{$this->numero_produit}";
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    // Les stators en attente
    public function scopeAttente($query)
    {
        return $query->where('etat', 'attente');
    }

    public function scopeEnCours($query)
    {
        return $query->where('etat', 'en_cours');
    }

    public function scopeTermines($query)
    {
        return $query->where('etat', 'termine');
    }

    // Filtrer par opération (ex : bobinage stator)
    public function scopeOperation($query, string $op)
    {
        return $query->where('operation', $op);
    }
}
