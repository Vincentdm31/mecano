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
            [
                'name' => 'vins',
                'email' => 'vins@vins.vins',
                'password' => Hash::make('laravelcop'),
                'is_admin' => '0'
            ],
            [
                'name' => 'toto',
                'email' => 'toto@vins.vins',
                'password' => Hash::make('laravelcop'),
                'is_admin' => '0'
            ],
            [
                'name' => 'admin',
                'email' => 'admin@vins.vins',
                'password' => Hash::make('laravelcop'),
                'is_admin' => '1'
            ]
        ]);

        DB::table('pieces')->insert([
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

        DB::table('categories')->insert([
            ['name' => 'Vidange'], ['name' => 'Pneumatique'], ['name' => 'Freinage'], ['name' => 'Distribution'],
            ['name' => 'Embrayage'], ['name' => 'Boite de vitesse'], ['name' => 'Batterie'], ['name' => 'Alternateur'],
            ['name' => 'Direction'], ['name' => 'Echappement'], ['name' => 'PBM Electrique'], ['name' => 'PBM Chauffage'],
            ['name' => 'PBM Ventilation'], ['name' => 'PBM Clim'], ['name' => 'Rétroviseur'], ['name' => 'Eclairage'],
            ['name' => 'Signalisation'], ['name' => 'PREPA CT'], ['name' => 'Contrôle general'], ['name' => 'Contrôle Niveaux'],
            ['name' => 'Nettoyage'], ['name' => 'Convoyage'], ['name' => 'Déplacement'], ['name' => 'Carrosserie'],
            ['name' => 'Courroie + galet'], ['name' => 'Pompe à eau'], ['name' => 'Géométrie'], ['name' => 'Diagnostic'],

        ]);
    }
}
