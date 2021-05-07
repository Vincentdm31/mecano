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
            [
                'ref' => 'FORFCN',
                'name' => 'Forfait Contrôle des Niveaux',
                'price' => 10,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFCN1',
                'name' => 'Forfait Contrôle des Niveaux Cat2',
                'price' => 15,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFCT1',
                'name' => 'Forfait Preparation CT -10P',
                'price' => 22,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFCT2',
                'name' => 'Forfait Preparation CT 10-21P',
                'price' => 30,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFCT3',
                'name' => 'Forfait Preparation CT +21P',
                'price' => 45,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFDES1',
                'name' => 'Forfait Desinfection VL -10P',
                'price' => 45,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFDES2',
                'name' => 'Forfait Desinfection VL 10-21P',
                'price' => 55,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFDES3',
                'name' => 'Forfait Desinfection VL +21P',
                'price' => 60,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFFLO',
                'name' => 'Forfait pose flocage',
                'price' => 25,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFK1',
                'name' => 'Forfait KIT Reparation VL',
                'price' => 5,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFK2',
                'name' => 'Forfait KIT Reparation PL',
                'price' => 10,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFKPR1',
                'name' => 'Forfait Kit Protection Plexiglass -10P',
                'price' => 62.5,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFKPR2',
                'name' => 'Forfait kit Protection Plexiglass 10-21P',
                'price' => 90,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFKPR3',
                'name' => 'Forfait kit Protection Plexiglass +21P',
                'price' => 100,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFME',
                'name' => 'Forfait Montage Equilibrage -30P',
                'price' => 15,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFME2',
                'name' => 'Forfait Montage Equilibrage +30P',
                'price' => 30,
                'isPackage' => true
            ],
            [
                'ref' => 'FORF-NC1',
                'name' => 'Forfait Nettoyage Complet -10P',
                'price' => 25,
                'isPackage' => true
            ],
            [
                'ref' => 'FORF-NC2',
                'name' => 'Forfait Nettoyage Complet 10-21P',
                'price' => 55,
                'isPackage' => true
            ],
            [
                'ref' => 'FORF-NC3',
                'name' => 'Forfait Nettoyage Complet +21P',
                'price' => 60,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFNE1',
                'name' => 'Forfait Nettoyage Exterieur -10P',
                'price' => 10,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFNE2',
                'name' => 'Forfait Nettoyage Exterieur 10-21P',
                'price' => 25,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFNE3',
                'name' => 'Forfait Nettoyage Exterieur +21P',
                'price' => 25,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFNI1',
                'name' => 'Forfait Nettoyage Intérieur -10P',
                'price' => 15,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFNI2',
                'name' => 'Forfait Nettoyage Intérieur 10-21P',
                'price' => 30,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFNI3',
                'name' => 'Forfait Nettoyage Intérieur +21P',
                'price' => 35,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFPARA',
                'name' => 'Forfait Parallèlisme',
                'price' => 50,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFRC1',
                'name' => 'Forfait Recharge Clim',
                'price' => 45,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFRC2',
                'name' => 'Forfait Recharge Clim Cat2',
                'price' => 80,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFRCD',
                'name' => 'Forfait Recharge Clim Double Circuit',
                'price' => 160,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFRCL3',
                'name' => 'Forfait Recharge Clim PL',
                'price' => 350,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFRCLDC',
                'name' => 'Forfait Révision Clim Double Compress',
                'price' => 500,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFRP',
                'name' => 'Forfait Reparation Pneu 0-30P',
                'price' => 24,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFRP2',
                'name' => 'Forfait Reparation Pneu +30P',
                'price' => 60,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFVAL1',
                'name' => 'Forfait Passage Valise -10P',
                'price' => 45,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFVAL2',
                'name' => 'Forfait Passage Valise 10-21P',
                'price' => 55,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFVAL3',
                'name' => 'Forfait Passage Valise +21P',
                'price' => 60,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFVIDC1',
                'name' => 'Forfait Vidange Complete -10P',
                'price' => 110,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFVIDC2',
                'name' => 'Forfait Vidange Complete 10-21P',
                'price' => 170,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFVIDC3',
                'name' => 'Forfait Vidange Complete +21P',
                'price' => 350,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFVIDS1',
                'name' => 'Forfait Vidange Simple -10P',
                'price' => 80,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFVIDS2',
                'name' => 'Forfait Vidange Simple 10-21P',
                'price' => 95,
                'isPackage' => true
            ],
            [
                'ref' => 'FORFVIDS3',
                'name' => 'Forfait Vidange Simple +21P',
                'price' => 200,
                'isPackage' => true
            ],
            [
                'ref' => 'MO1',
                'name' => 'Main d\'Oeuvre vehicule -10P',
                'price' => 45,
                'isPackage' => false
            ],
            [
                'ref' => 'MO2',
                'name' => 'Main d\'Oeuvre vehicule 10-21P',
                'price' => 55,
                'isPackage' => false
            ],
            [
                'ref' => 'MO3',
                'name' => 'Main d\'Oeuvre vehicule -21P',
                'price' => 60,
                'isPackage' => false
            ],
            [
                'ref' => 'T1PL',
                'name' => 'Montage/Demontage PL',
                'price' => 55,
                'isPackage' => false
            ],
            [
                'ref' => 'T1VL',
                'name' => 'Montage/Demontage VL',
                'price' => 45,
                'isPackage' => false
            ],
            [
                'ref' => 'T1VL1',
                'name' => 'Demontage VL',
                'price' => 60,
                'isPackage' => false
            ],
            [
                'ref' => 'T2PL',
                'name' => 'Redressage/Masticage PL ',
                'price' => 60,
                'isPackage' => false
            ],
            [
                'ref' => 'T2VL',
                'name' => 'Redressage/Masticage VL',
                'price' => 50,
                'isPackage' => false
            ],
            [
                'ref' => 'T2VL1',
                'name' => 'Masgtiquage VL',
                'price' => 70,
                'isPackage' => false
            ],
            [
                'ref' => 'PPPL',
                'name' => 'Peinture PL',
                'price' => 45,
                'isPackage' => false
            ],
            [
                'ref' => 'PPVL',
                'name' => 'Peinture VL',
                'price' => 45,
                'isPackage' => false
            ],
            [
                'ref' => 'PPVL1',
                'name' => 'Peinture VL 2',
                'price' => 60,
                'isPackage' => false
            ],
            [
                'ref' => 'IGPL',
                'name' => 'Ingrédient Peinture',
                'price' => 35,
                'isPackage' => false
            ],
            [
                'ref' => 'IGVL',
                'name' => 'Ingrédient Peinture 2',
                'price' => 35,
                'isPackage' => false
            ],
        ]);



    }
}
