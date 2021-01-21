<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'vins',
            'email' => 'vins@vins.vins',
            'password' => Hash::make('azsqazsq'),
            'is_admin' => '0'
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@vins.vins',
            'password' => Hash::make('azsqazsq'),
            'is_admin' => '1'
        ]);

        DB::table('vehicules')->insert([
            'marque' => 'peugeot',
            'modele' => '206',
            'immat' => 'AV546VH'
        ]);
        DB::table('vehicules')->insert([
            'marque' => 'bmw',
            'modele' => '450',
            'immat' => 'ui565ki'
        ]);
        DB::table('vehicules')->insert([
            'marque' => 'renault',
            'modele' => 'twingo',
            'immat' => 'azHzvez'
        ]);
    }
}
