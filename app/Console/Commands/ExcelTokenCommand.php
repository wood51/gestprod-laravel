<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\User;

class ExcelTokenCommand extends Command
{
    protected $signature = 'excel:token 
        {username=excel : Identifiant du compte technique} 
        {--name=excel : Nom du token} 
        {--abilities=machines:read,machines:write : Liste d\'abilities (séparées par des virgules)} 
        {--rotate : Révoque les anciens tokens de ce nom avant d\'en créer un}';

    protected $description = 'Crée (ou met à jour) un user technique et génère un token Sanctum pour Excel/Power Query.';

    public function handle(): int
    {
        // Sanity check Sanctum
        if (! class_exists(\Laravel\Sanctum\Sanctum::class)) {
            $this->error("Sanctum n'est pas installé. Fais :
  composer require laravel/sanctum
  php artisan vendor:publish --provider=\"Laravel\\Sanctum\\SanctumServiceProvider\"
  php artisan migrate");
            return self::FAILURE;
        }

        $username  = (string) $this->argument('username');
        $tokenName = (string) $this->option('name');
        $abilities = array_filter(array_map('trim', explode(',', (string) $this->option('abilities'))));

        // Trouve ou crée l'utilisateur technique (sans se prendre les pieds dans $fillable)
        $user = User::where('username', $username)->first();
        $created = false;
        $generatedPassword = null;

        if (! $user) {
            $user = new User();
            // champs minimaux
            if (Schema::hasColumn('users', 'username')) $user->username = $username;
            if (Schema::hasColumn('users', 'email'))    $user->email    = $username.'@local';
            if (Schema::hasColumn('users', 'nom'))      $user->nom      = 'Excel';
            if (Schema::hasColumn('users', 'prenom'))   $user->prenom   = 'Bot';
            if (Schema::hasColumn('users', 'role'))     $user->role     = 'user';
            if (Schema::hasColumn('users', 'site'))     $user->site     = '1AB';

            $generatedPassword = Str::random(20);
            if (Schema::hasColumn('users', 'password')) $user->password = Hash::make($generatedPassword);

            $user->save();
            $created = true;
        }

        if (! method_exists($user, 'createToken')) {
            $this->error("Ton modèle User n'utilise pas le trait HasApiTokens. Ajoute-le :
use Laravel\\Sanctum\\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, Notifiable;
}");
            return self::FAILURE;
        }

        if ($this->option('rotate')) {
            $user->tokens()->where('name', $tokenName)->delete();
        }

        $plainTextToken = $user->createToken($tokenName, $abilities)->plainTextToken;

        $this->info("✅ Token créé pour '{$username}'");
        $this->line("Nom du token : {$tokenName}");
        $this->line('Abilities : '.implode(',', $abilities));
        $this->newLine();
        $this->warn('➡️  COPIE IMMÉDIATEMENT (affiché une seule fois) :');
        $this->line($plainTextToken);

        if ($created) {
            $this->newLine();
            $this->info("👤 Utilisateur '{$username}' créé.");
            if ($generatedPassword) {
                $this->warn("Mot de passe initial (si utile pour login) : {$generatedPassword}");
            }
        }

        $this->newLine();
        $this->line('Astuce Excel Power Query : crée un paramètre `ApiToken` et mets-le dans le header:');
        $this->line('Headers = [ Authorization = "Bearer " & ApiToken ]');

        return self::SUCCESS;
    }
}
