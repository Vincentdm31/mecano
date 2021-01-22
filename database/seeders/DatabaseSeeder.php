<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'password' => Hash::make('laravelcop'),
            'is_admin' => '0'
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@vins.vins',
            'password' => Hash::make('laravelcop'),
            'is_admin' => '1'
        ]);


        for ($i = 0; $i < 300; $i++){
            DB::table('vehicules')->insert([
                'marque' => 'Peugeot',
                'modele' => Str::random(4),
                'immat' => Str::random(5)
            ]);
            DB::table('vehicules')->insert([
                'marque' => 'Lambo',
                'modele' => Str::random(4),
                'immat' => Str::random(5)
            ]);
            DB::table('vehicules')->insert([
                'marque' => 'Peugeot',
                'modele' => Str::random(4),
                'immat' => Str::random(5)
            ]);
            DB::table('vehicules')->insert([
                'marque' => 'Mercedes',
                'modele' => Str::random(4),
                'immat' => Str::random(5)
            ]);
            DB::table('vehicules')->insert([
                'marque' => 'Iveco',
                'modele' => Str::random(4),
                'immat' => Str::random(5)
            ]);
        }
        
    }
}
