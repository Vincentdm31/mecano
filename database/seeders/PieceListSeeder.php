<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PieceListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('piece_lists')->insert([
            [
                'name' => 'piece1',
                'ref' => 'ref1',
                'price' => '12',
                'qte' => '5'
            ],
            [
                'name' => 'piece2',
                'ref' => 'ref2',
                'price' => '14',
                'qte' => '8'
            ],
            [
                'name' => 'piece3',
                'ref' => 'ref3',
                'price' => '123',
                'qte' => '55'
            ]
        ]);
    }
}
