<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Schemas\Components\Component;   // v4 Schemas
use Filament\Forms\Components\TextInput;

class Login extends BaseLogin
{
    // Remplace le champ "email" du formulaire par défaut
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')      // ⚠️ garde la clé "email" (binding interne)
            ->label('Identifiant')
            ->autocomplete('username')
            ->required();                    // ne PAS appeler ->email() => restera <input type="text">
    }

    // Authentifie avec username + password
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['email'] ?? null,   // email du form = ton username
            'password' => $data['password'] ?? null,
        ];
    }

    protected function hasRemember(): bool { return false; }
}
