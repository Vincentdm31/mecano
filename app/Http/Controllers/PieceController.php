<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Models\Piece;
use App\Models\PieceList;
use Illuminate\Http\Request;

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

        if ($pieceQte <= $qte) {
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

    public function destroy(Request $request, $id)
    {
        $intervention = Intervention::find($request->interventionId);
        $piece = Piece::find($id);
        $pieceList = PieceList::find($piece->piece_id);

        if ($piece->qte > 0) {
            $piece->qte -= 1;
        }

        $piece->save();

        if ($piece->qte <= 0) {
            $piece->delete();
        }

        $pieceList->qte += 1;
        $pieceList->save();

        return redirect(route('interventions.edit', ['intervention' => $intervention]))->with('toast', 'pieceDelete');
    }
}
