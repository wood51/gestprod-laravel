<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName; // ⬅️
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements FilamentUser
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

    // ⚠️ Doit TOUJOURS renvoyer une string non nulle
    public function getFilamentName(): string
    {
        return trim(($this->prenom ?: '') . ' ' . ($this->nom ?: '')) ?: ($this->username ?: 'Admin');
    }

     // ✅ Filament cherche souvent "name" → on le fournit.
    public function getNameAttribute(): string
    {
        return $this->getFilamentName();
    }


    /**
     * Filament : qui a le droit d’accéder au panel ?
     * Ici uniquement les admins.
     */
    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Mutateur : dès qu’on attribue un mot de passe en clair,
     * il est automatiquement hashé en bcrypt.
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] =
            str_starts_with((string) $value, '$2y$')
            ? $value // déjà hashé
            : Hash::make($value);
    }

}
