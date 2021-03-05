<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class VehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {
            DB::table('vehicules')->insert([
                [
                    'marque' => 'Peugeot',
                    'modele' => Str::random(4),
                    'immat' => Str::random(5)
                ],
                [
                    'marque' => 'Renault',
                    'modele' => Str::random(4),
                    'immat' => Str::random(5)
                ],
                [
                    'marque' => 'Citroen',
                    'modele' => Str::random(4),
                    'immat' => Str::random(5)
                ],
            ]);
        }
    }
}
