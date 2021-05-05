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
                'name' => 'meca1',
                'email' => 'meca1@meca.meca',
                'password' => Hash::make('alcismeca'),
                'role' => '0'
            ],
            [
                'name' => 'meca2',
                'email' => 'meca2@meca.meca',
                'password' => Hash::make('alcismeca'),
                'role' => '0'
            ],
            [
                'name' => 'Françoise',
                'email' => 'francoise@meca.meca',
                'password' => Hash::make('alcismeca'),
                'role' => '4'
            ],
            [
                'name' => 'magasinier',
                'email' => 'magasinier@meca.meca',
                'password' => Hash::make('alcismeca'),
                'role' => '1'
            ],
            [
                'name' => 'admin',
                'email' => 'admin@meca.meca',
                'password' => Hash::make('alcismeca'),
                'role' => '2'
            ],
            [
                'name' => 'root',
                'email' => 'root@meca.meca',
                'password' => Hash::make('alcismeca'),
                'role' => '3'
            ]
        ]);

        $this->call(OperationListSeeder::class);
        $this->call(PieceListSeeder::class);
    }
}
