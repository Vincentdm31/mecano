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

        $opList = ['Vidange simple', 'Vidange intermédiaire', 'Vidange complète', 'Pneumatique', 'Montage Pneu', 'Freinage', 'Géométrie',
                    'Contrôle des niveaux', 'Nettoyage', 'Révision simple', 'Révision complète', 'Distribution', 'Embrayage', 'Boite de vitesse',
                    'Forfait Batterie', 'Alternateur', 'Direction', 'Echappement', 'PBM Electrique', 'PBM Chauffage', 'PBM Ventilation', 'PBM Clim', 'Rétroviseur',
                    'Eclairage', 'PREPA CT', 'Convoyage', 'Déplacement', 'Carrosserie', 'Courroie + galet', 'Pompe à eau', 'Géométrie', 
                    'Diagnostic'
                  ];

        sort($opList);

        foreach($opList as $item){
            DB::table('operation_lists')->insert([
                'name' => $item
            ]);
        }
    }
}
