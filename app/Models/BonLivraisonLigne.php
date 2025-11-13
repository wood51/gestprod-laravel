<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class BonLivraisonLigne extends Model
{

    public function realisation()
    {
        return $this->belongsTo(Realisation::class);
    }

    // Accessors
    protected function numeroMeta(): Attribute
    {
        return Attribute::make(
             get: fn ($value): array => (array) (json_decode($this->planning?->numero_meta,true) ?? json_decode($value, true) ?? [])
        );
    }


    protected function articleRef(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => (string)  ($this->planning?->article->reference ?? $value )
        );
    }

    protected function articleDesignation(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => (string)  ($this->planning?->article->designation ?? $value )
        );
    }

    protected function noCommande(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => (string) ($this->planning?->no_commande ?? $value )
        );
    }
    protected function noPoste(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => (string) ($this->planning?->no_poste ?? $value )
        );
    }
}
