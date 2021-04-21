<?php

namespace Database\Seeders;

use App\Models\PieceList;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PieceListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {

            $pieceList = new PieceList();
            $pieceList->name = 'piece' . $i;
            $pieceList->ref = 'ref' . $i;
            $pieceList->price =  $i * 2;
            $pieceList->qte =  $i + 5;

            $qrcode = QrCode::size(200)->generate('ref' . $i);

            Storage::put('/public/images/' . 'qr-' . 'ref' . $i . '.svg', $qrcode);

            $pieceList->path = 'qr-' . 'ref' . $i . '.svg';

            try {
                $pieceList->save();
            } catch (Exception $e) {
                dd('Error' . $e);
            }
        }
    }
}
