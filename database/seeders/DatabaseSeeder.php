<?php

namespace Database\Seeders;

use App\Models\PieceList;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Whoops\Run;

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
            [
                'name' => 'vins',
                'email' => 'vins@vins.vins',
                'password' => Hash::make('totoalcis'),
                'is_admin' => '0'
            ],
            [
                'name' => 'toto',
                'email' => 'toto@vins.vins',
                'password' => Hash::make('totoalcis'),
                'is_admin' => '0'
            ],
            [
                'name' => 'admin',
                'email' => 'admin@vins.vins',
                'password' => Hash::make('totoalcis'),
                'is_admin' => '1'
            ]
        ]); 

        $this->call(OperationListSeeder::class);
        $this->call(PieceListSeeder::class);
        $this->call(VehiculeSeeder::class);
    }
}
