<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VueEngagementSynthese extends Model
{
    // Nom exact de la vue
    protected $table = 'vue_engagement_syntheses';

    // Pas de timestamps (created_at, updated_at)
    public $timestamps = false;

    // Clé primaire non standard → tu peux la désactiver
    protected $primaryKey = null;
    public $incrementing = false;

    // Empêche toute modification (readonly)
    public function save(array $options = [])
    {
        throw new \Exception("Cette vue est en lecture seule.");
    }
}