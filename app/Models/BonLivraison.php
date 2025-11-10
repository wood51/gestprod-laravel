<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BonLivraison extends Model
{
    protected $fillable = ['validated_at', 'canceled_at', 'created_by', 'validated_by', 'canceled_by'];

    protected $with = [
        'createdBy:id,nom,prenom,username',
        'validatedBy:id,nom,prenom,username',
        'canceledBy:id,nom,prenom,username',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'validated_at' => 'datetime',
        'canceled_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function lignes()
    {
        return $this->hasMany(BonLivraisonLigne::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function validatedBy()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function canceledBy()
    {
        return $this->belongsTo(User::class, 'canceled_by');
    }

    public function hasLines()
    {
        return $this->lignes()->exists();
    }

    public function typeSousEnsemble() {
        return $this->BelongsTo(TypeSousEnsemble::class);
    }
}
