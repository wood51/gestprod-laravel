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
        'code_prefix'
    ];

    public function realisation()
    {
        return $this->belongsTo(Realisation::class);
    }


    public function bonLivraison()
    {
        return $this->belongsTo(\App\Models\BonLivraison::class);
    }

    // Accessors

    protected function numeroMeta(): Attribute
    {
        return Attribute::make(
            get: function ($value): array {
                // Valeur directe du modèle
                $decoded = json_decode($value, true);

                if (is_array($decoded)) {
                    return $decoded;
                }

                // Fallback sur la relation
                $relationValue = json_decode($this->realisation?->numero_meta ?? '[]', true);

                return is_array($relationValue) ? $relationValue : [];
            }
        );
    }



    protected function articleRef(): Attribute
    {
        return Attribute::make(
            get: fn($value): string => (string)  ($this->realisation?->article->ref_client ?? $value)
        );
    }

    protected function articleInterne(): Attribute
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
