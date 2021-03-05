<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperationListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('operation_lists')->insert([
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
