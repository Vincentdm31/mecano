<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use App\Models\PieceList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PieceController extends Controller
{
    public function store(Request $request)
    {   
        $refPiece = $request->pieceref;
        $operationId = $request->operationId;
        $intervention = $request->interventionId;
        $qte = $request->qte;

        $pieceId = PieceList::Where('ref', 'like', '%' . $refPiece . '%')->get()->pluck('id')->implode('');
        $pieceQte = PieceList::Where('ref', 'like', '%' . $refPiece . '%')->get()->pluck('qte')->implode('');

        if($pieceQte <= $qte){
            return redirect(route('interventions.edit', ['intervention' => $intervention, 'pieceQte' => $pieceQte]))->with('toast', 'notEnoughQte');
        }

        $piece = new Piece();

        $piece->piece_id = $pieceId;
        $piece->operation_id = $operationId;
        $piece->qte = $qte;
        $piece->save();

        $pieceListId = PieceList::find($pieceId);
        $pieceListId->qte -= $qte;
        $pieceListId->save();

        return redirect(route('interventions.edit', ['intervention' => $intervention]))->with('toast', 'pieceStore');

    }
}
