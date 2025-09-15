<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create(
            [
                'nom' => 'poulin',
                'prenom' => 'david',
                'username' => 'dpo1',
                'password' => Hash::make('david'),
                'role' => 'admin',
                'site' => '2'
            ]
        );
    }
}
