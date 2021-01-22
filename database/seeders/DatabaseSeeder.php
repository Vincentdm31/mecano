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


        for ($i = 0; $i < 10000; $i++){
            DB::table('vehicules')->insert([
                'marque' => Str::random(10).'marque',
                'modele' => Str::random(10).'modele',
                'immat' => Str::random(5)
            ]);
        }
        
    }
}
