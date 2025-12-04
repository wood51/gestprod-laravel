<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class BonLivraisonLigne extends Model
{
    protected $fillable = [
        'bon_livraison_id',
        'realisation_id',
        'numero_meta',
        'article_ref',
        'article_designation',
        'quantite',
        'no_commande',
        'no_poste',
    ];

    public function realisation()
    {
        return $this->belongsTo(Realisation::class);
    }

    // Accessors
    protected function numeroMeta(): Attribute
    {
        return Attribute::make(
            get: fn($value): array => (array) (json_decode($this->realisation?->numero_meta, true) ?? json_decode($value, true) ?? [])
        );
    }


    protected function articleRef(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => (string)  ($this->realisation?->article->reference ?? $value)
        );
    }

    protected function articleDesignation(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => (string)  ($this->realisation?->article->designation ?? $value)
        );
    }

    protected function noCommande(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => (string) ($this->realisation?->no_commande ?? $value)
        );
    }
    protected function noPoste(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => (string) ($this->realisation?->no_poste ?? $value)
        );
    }
}
