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
                    'mark' => 'Peugeot',
                    'model' => Str::random(4),
                    'license_plate' => Str::random(5),
                    'category' => rand(1,3)
                ]
            ]);
        }
    }
}
