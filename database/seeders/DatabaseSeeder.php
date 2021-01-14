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
    }
}
