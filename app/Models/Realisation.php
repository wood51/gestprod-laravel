<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Realisation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'article_id',
        'type_sous_ensemble_id',
        'numero',
        'semaine',
        'engagement',
        'commentaire',
        'prete',
    ];

    // Relations de base
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function typeSousEnsemble()
    {
        return $this->belongsTo(TypeSousEnsemble::class, 'type_sous_ensemble_id');
    }

    public function controleProduits()
    {
        // à terme il faudra sûrement renommer la FK en realisation_id,
        // mais pour l’instant on laisse comme ça si ta BDD est encore en planning_id
        return $this->hasMany(ControleProduit::class, 'planning_id');
    }

    // 🔗 Lignes de BL liées à cette réalisation
    public function bonLivraisonLignes()
    {
        return $this->hasMany(BonLivraisonLigne::class, 'realisation_id');
    }

    // 🔗 BL liés via les lignes
    public function bonLivraisons()
    {
        return $this->belongsToMany(
            BonLivraison::class,
            'bon_livraison_lignes', // table pivot
            'realisation_id',       // FK vers Realisation dans la pivot
            'bon_livraison_id'      // FK vers BonLivraison dans la pivot
        );
    }

    public function map() {
        return $this->belongsTo(v10_pa_map::class);
    }

    // Accessor num_bl "virtuel"
    protected function numBl(): Attribute
    {
        return Attribute::make(
            get: fn(): array => $this->bonLivraisons()
                ->pluck('bon_livraisons.id')
                ->all()
        );
    }
}
