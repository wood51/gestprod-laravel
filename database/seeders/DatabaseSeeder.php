<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'nom' => 'poulin',
            'prenom' => 'david',
            'username' =>'dpo1',
            'password'=> Hash::make('david'),
            'role' => 'admin',
            'site' => '2'
        ]);
    }
}